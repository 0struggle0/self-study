# 巧用 Redis Hyperloglog，轻松统计 UV 数据

如果你正在开发一个基于“事件”的应用程序，该应用程序可以处理来自不同用户的许多请求，那么你很大可能希望能够计算滑动窗口或指定时间范围内不同的用户操作。

计数不同用户行为的最快方法之一是写一个类似 `SELECT COUNT(DISTINCT user)` 的 SQL。但是，如果实时数据的量达到了上百万条，这可能会很昂贵。你可能会想到另一种方法，就是将用户保存在一个 Redis set 集合中，因为 set 天然具备去重的功能。

但是，这种解决方案也带来了它固有的问题。如果一个统计不同用户记录的应用程序运行有多个实例，那么我们需要具有巨大 RAM 大小的内存缓存解决方案。如果要处理 1000 万个不同的记录，每个记录分配 10 字节，那么仅在一个时间范围内我们就至少需要 100MB 的内存。因此，这不是内存有效的解决方案。

在本文中，我想向你展示如何通过在 Redis Cache 服务器中分配少于 2MB 的内存来处理一百万个不同的用户记录。

我们都知道，Redis 有好几种数据结构，比如：String、BitMap、Set、Sorted Set 等。在这里我想特别强调一下`Hyperloglog`，因为它最适合通过减少内存消耗来统计不同的用户操作。

![redis-data](https://segmentfault.com/img/remote/1460000020523113)

## Hyper LogLog

Hyper LogLog 计数器的名称是具有自描述性的。 你可以仅仅使用`loglog(Nmax)+ O(1)`位来估计基数为 Nmax 的集合的基数。

## Redis Hyperloglog 操作

要进行 Redis Hyperloglog 的操作，我们可以使用以下三个命令：

- `PFADD`
- `PFCOUNT`
- `PFMERGE`

我们用一个实际的例子来解释这些命令。比如，有这么个场景，用户登录到系统，我们需要在一小时内统计不同的用户。 因此，我们需要一个 key，例如 USER:LOGIN:2019092818。 换句话说，我们要统计在 2019 年 09 月 28 日下午 18 点至 19 点之间发生用户登录操作的非重复用户数。对于将来的时间，我们也需要使用对应的 key 进行表示，比如 2019111100、2019111101、2019111102 等。

我们假设，用户 A、B、C、D、E 和 F 在下午 18 点至 19 点之间登录了系统。

```PHP
127.0.0.1:6379> pfadd USER:LOGIN:2019092818 A
(integer) 1
127.0.0.1:6379> pfadd USER:LOGIN:2019092818 B C D E F
(integer) 1
127.0.0.1:6379>
```

当进行计数时，你会得到预期的 6。

```
127.0.0.1:6379> pfcount USER:LOGIN:2019092818
(integer) 6
```

如果 A 和 B 在这个时间内多次登录系统，你也将得到相同的结果，因为我们仅保留不同的用户。

```
127.0.0.1:6379> pfadd USER:LOGIN:2019092818 A B
(integer) 0
127.0.0.1:6379> pfcount USER:LOGIN:2019092818
(integer) 6
```

如果用户 A~F 和另外一个其他用户 G 在下午 19 点至下午 20 点之间登录系统：

```
127.0.0.1:6379> pfadd USER:LOGIN:2019092819 A B C D E F G
(integer) 1
127.0.0.1:6379> pfcount USER:LOGIN:2019092819
(integer) 7
```

现在，我们有两个键 USER:LOGIN:2019092818 和 USER:LOGIN:2019092819，如果我们想知道在 18 点到 20 点（2 小时）之间有多少不同的用户登录到系统中，我们可以直接使用`pfcount`命令对两个键进行合并计数：

```
127.0.0.1:6379> pfcount USER:LOGIN:2019092818 USER:LOGIN:2019092819
(integer) 7
```

如果我们需要保留键值而避免一遍又一遍地计数，那么我们可以将键合并为一个键 USER:LOGIN:2019092818-19，然后直接对该键进行`pfcount`操作，如下所示。

```
127.0.0.1:6379> pfmerge USER:LOGIN:2019092818-19 USER:LOGIN:2019092818 USER:LOGIN:2019092819
OK
127.0.0.1:6379> pfcount USER:LOGIN:2019092818-19
(integer) 7
```

接下来，我们写个程序，比较使用 SET、Hyperloglog 两种方式存储不同用户登录行为的内存占用。

```
import redis.clients.jedis.Jedis;

public class RedisTest {
    
    private static final int NUM = 1000000;  // 100万用户

    private static final String SET_KEY = "SET:USER:LOGIN:2019082811";
    private static final String PF_KEY = "PF:USER:LOGIN:2019082811";

    public static void main(String[] args) {
        Jedis client = new Jedis();
        for (int i = 0; i < NUM; ++i) {
            System.out.println(i);
            client.sadd(SET_KEY, "USER" + i);
            client.pfadd(PF_KEY, "USER" + i);
        }
    }
}
```

我们看一下结果，对于 100 万用户，Set 可以精确存储，而 Hyperloglog 则稍有偏差，多出了 7336，误差率大概是在 `0.7%`。而在内存占用上，Set 消耗了 10888895B≈10MB，Hyperloglog 只消耗了 10481B≈10KB 的内存，几乎是 Set 的 1/1000。

```
127.0.0.1:6379> scard SET:USER:LOGIN:2019082811
(integer) 1000000
127.0.0.1:6379> pfcount PF:USER:LOGIN:2019082811
(integer) 1007336

127.0.0.1:6379> debug object SET:USER:LOGIN:2019082811
Value at:00007FD74F841940 refcount:1 encoding:hashtable serializedlength:10888895 lru:9308508 lru_seconds_idle:53
127.0.0.1:6379> debug object PF:USER:LOGIN:2019082811
Value at:00007FD74F7A5940 refcount:1 encoding:raw serializedlength:10481 lru:9308523 lru_seconds_idle:50
```

> serializedlength 参数表示该 key 存储的内容所占用的内存字节数。

## 滑动窗口的不同计数

要在滑动窗口中计算不同的用户，我们需要指定一个较小的粒度，在这种情况下，分钟级的就足够了，我们将用户行为保存在格式为 yyyyMMddHHmm 的键中，例如 USER:LOGIN:201909281820。

当我们要统计最后 5 分钟的不同用户操作时，只需要将 5 个键进行合并计算即可：

```
127.0.0.1:6379> pfcount 201909281821 201909281822 201909281823 201909281824 201909281825

(integer) 6
```

由此看来，统计最近一小时我们需要 60 个键，统计最近一天需要 1440 个键，最近 7 天则需要 10080 个键。 我们拥有的键越多，合并它们时就需要耗费更多的时间进行计算。 因此，我们应该减少键的数量，不仅要保留具有 yyyyMMddHHmm 格式的键，还应保留小时、日和月的时间间隔，并使用 yyyyMM，yyyyMMdd，yyyyMMddHH。

使用这些新键，pfcount 操作可以花费更少的时间，例如：

如果你要计算用户最近一天的操作并且仅使用分钟键，你需要合并所有 1440 个键。但是，如果你在分钟键之外还使用小时键，则只需要 60 个分钟键和 24 个小时键，因此我们只需要 84 个键。

```java
public class HLLUtils {
    private static String TIME_FORMAT_MONTH_DAY = "MMdd";
    private static String TIME_FORMAT_DAY_MINUTES = "MMddHHmm";
    private static String TIME_FORMAT_DAY_HOURS = "MMddHH";
    private static SimpleDateFormat FORMAT_MONTH_DAY = new SimpleDateFormat(TIME_FORMAT_MONTH_DAY);
    private static SimpleDateFormat FORMAT_DAY_HOURS = new SimpleDateFormat(TIME_FORMAT_DAY_HOURS);
    private static SimpleDateFormat FORMAT_DAY_MINUTES = new SimpleDateFormat(TIME_FORMAT_DAY_MINUTES);

    /**
     * 获取两个日期之间的键
     *
     * @param d1 日期1
     * @param d2 日期2
     * @return 键列表
     */
    public static List<String> parse(Date d1, Date d2) {
        List<String> list = new ArrayList<>();
        if (d1.compareTo(d2) == 0) {
            return list;
        }
        
        long delta = d2.getTime() - d1.getTime(); 
        
        if (delta == 0) {
            return list;
        }
        
        if (delta < DateUtils.MILLIS_PER_HOUR) {   // 若时间差小于 1 小时
        
            int minutesDiff = (int) (delta / DateUtils.MILLIS_PER_MINUTE);
            Date date1Increment = d1;
            while (d2.compareTo(date1Increment) > 0 && minutesDiff > 0) {
                list.add(FORMAT_DAY_MINUTES.format(date1Increment));
                date1Increment = DateUtils.addMinutes(date1Increment, 1);
            }
           
        } else if (delta < DateUtils.MILLIS_PER_DAY) {  // 若时间差小于 1 天
        
            Date dateLastPortionHour = DateUtils.truncate(d2, Calendar.HOUR_OF_DAY);
            list.addAll(parse(dateLastPortionHour, d2));
            long delta2 = dateLastPortionHour.getTime() - d1.getTime();
            int hoursDiff = (int) (delta2 / DateUtils.MILLIS_PER_HOUR);
            Date date1Increment = DateUtils.addHours(dateLastPortionHour, -1 * hoursDiff);
            while (dateLastPortionHour.compareTo(date1Increment) > 0 && hoursDiff > 0) {
                list.add(FORMAT_DAY_HOURS.format(date1Increment));
                date1Increment = DateUtils.addHours(date1Increment, 1);
            }
            list.addAll(parse(d1, DateUtils.addHours(dateLastPortionHour, -1 * hoursDiff)));
        } else {
            Date dateLastPortionDay = DateUtils.truncate(d2, Calendar.DAY_OF_MONTH);
            list.addAll(parse(dateLastPortionDay, d2));
            long delta2 = dateLastPortionDay.getTime() - d1.getTime();
   
            int daysDiff = (int) (delta2 / DateUtils.MILLIS_PER_DAY); // 若时间差小于 1 个月
            
            Date date1Increment = DateUtils.addDays(dateLastPortionDay, -1 * daysDiff);
            while (dateLastPortionDay.compareTo(date1Increment) > 0 && daysDiff > 0) {
                list.add(FORMAT_MONTH_DAY.format(date1Increment));
                date1Increment = DateUtils.addDays(date1Increment, 1);
            }
            list.addAll(parse(d1, DateUtils.addDays(dateLastPortionDay, -1 * daysDiff)));
        }
        return list;
    }

    /**
     * 获取从 date 往前推 minutes 分钟的键列表
     *
     * @param date    特定日期
     * @param minutes 分钟数
     * @return 键列表
     */
    public static List<String> getLastMinutes(Date date, int minutes) {
        return parse(DateUtils.addMinutes(date, -1 * minutes), date);
    }

    /**
     * 获取从 date 往前推 hours 个小时的键列表
     *
     * @param date  特定日期
     * @param hours 小时数
     * @return 键列表
     */
    public static List<String> getLastHours(Date date, int hours) {
        return parse(DateUtils.addHours(date, -1 * hours), date);
    }

    /**
     * 获取从 date 开始往前推 days 天的键列表
     *
     * @param date 特定日期
     * @param days 天数
     * @return 键列表
     */
    public static List<String> getLastDays(Date date, int days) {
        return parse(DateUtils.addDays(date, -1 * days), date);
    }

    /**
     * 为keys列表添加前缀
     *
     * @param keys   键列表
     * @param prefix 前缀符号
     * @return 添加了前缀的键列表
     */
    public static List<String> addPrefix(List<String> keys, String prefix) {
        return keys.stream().map(key -> prefix + key).collect(Collectors.toList());
    }
}
```

我们来看一下两个日期之间计算出的样本键列表。 你可能已经意识到了，键的数量应该尽可能少，这样合并键进行统计时代价将会比较小。 因此，我们不仅要将时间范围划分为分钟，而且还要划分为小时、天、月等。

- BEGIN=201909281800&END=201909281920

```
[USER:LOGIN:09281900, USER:LOGIN:09281901, USER:LOGIN:09281902, USER:LOGIN:09281903, USER:LOGIN:09281904, USER:LOGIN:09281905, USER:LOGIN:09281906, USER:LOGIN:09281907, USER:LOGIN:09281908, USER:LOGIN:09281909, USER:LOGIN:09281910, USER:LOGIN:09281911, USER:LOGIN:09281912, USER:LOGIN:09281913, USER:LOGIN:09281914, USER:LOGIN:09281915, USER:LOGIN:09281916, USER:LOGIN:09281917, USER:LOGIN:09281918, USER:LOGIN:09281919, USER:LOGIN:092818]
```

- BEGIN=20190928191100&END=20190930163800

```
[USER:LOGIN:09301600, USER:LOGIN:09301601, USER:LOGIN:09301602, USER:LOGIN:09301603, USER:LOGIN:09301604, USER:LOGIN:09301605, USER:LOGIN:09301606, USER:LOGIN:09301607, USER:LOGIN:09301608, USER:LOGIN:09301609, USER:LOGIN:09301610, USER:LOGIN:09301611, USER:LOGIN:09301612, USER:LOGIN:09301613, USER:LOGIN:09301614, USER:LOGIN:09301615, USER:LOGIN:09301616, USER:LOGIN:09301617, USER:LOGIN:09301618, USER:LOGIN:09301619, USER:LOGIN:09301620, USER:LOGIN:09301621, USER:LOGIN:09301622, USER:LOGIN:09301623, USER:LOGIN:09301624, USER:LOGIN:09301625, USER:LOGIN:09301626, USER:LOGIN:09301627, USER:LOGIN:09301628, USER:LOGIN:09301629, USER:LOGIN:09301630, USER:LOGIN:09301631, USER:LOGIN:09301632, USER:LOGIN:09301633, USER:LOGIN:09301634, USER:LOGIN:09301635, USER:LOGIN:09301636, USER:LOGIN:09301637, USER:LOGIN:093000, USER:LOGIN:093001, USER:LOGIN:093002, USER:LOGIN:093003, USER:LOGIN:093004, USER:LOGIN:093005, USER:LOGIN:093006, USER:LOGIN:093007, USER:LOGIN:093008, USER:LOGIN:093009, USER:LOGIN:093010, USER:LOGIN:093011, USER:LOGIN:093012, USER:LOGIN:093013, USER:LOGIN:093014, USER:LOGIN:093015, USER:LOGIN:0929, USER:LOGIN:092820, USER:LOGIN:092821, USER:LOGIN:092822, USER:LOGIN:092823, USER:LOGIN:09281911, USER:LOGIN:09281912, USER:LOGIN:09281913, USER:LOGIN:09281914, USER:LOGIN:09281915, USER:LOGIN:09281916, USER:LOGIN:09281917, USER:LOGIN:09281918, USER:LOGIN:09281919, USER:LOGIN:09281920, USER:LOGIN:09281921, USER:LOGIN:09281922, USER:LOGIN:09281923, USER:LOGIN:09281924, USER:LOGIN:09281925, USER:LOGIN:09281926, USER:LOGIN:09281927, USER:LOGIN:09281928, USER:LOGIN:09281929, USER:LOGIN:09281930, USER:LOGIN:09281931, USER:LOGIN:09281932, USER:LOGIN:09281933, USER:LOGIN:09281934, USER:LOGIN:09281935, USER:LOGIN:09281936, USER:LOGIN:09281937, USER:LOGIN:09281938, USER:LOGIN:09281939, USER:LOGIN:09281940, USER:LOGIN:09281941, USER:LOGIN:09281942, USER:LOGIN:09281943, USER:LOGIN:09281944, USER:LOGIN:09281945, USER:LOGIN:09281946, USER:LOGIN:09281947, USER:LOGIN:09281948, USER:LOGIN:09281949, USER:LOGIN:09281950, USER:LOGIN:09281951, USER:LOGIN:09281952, USER:LOGIN:09281953, USER:LOGIN:09281954, USER:LOGIN:09281955, USER:LOGIN:09281956, USER:LOGIN:09281957, USER:LOGIN:09281958, USER:LOGIN:09281959]
```

## 实例

其实，有了上面生成 key 的方法，我们便可以很轻松地在实际场景中应用 Redis 的 HyperLoglog 进行数据统计，比如我们要统计从此刻开始往前推一小时、一天、一周的 UV。

代码实现如下：

```java
import redis.clients.jedis.Jedis;
import utils.JedisUtils;

import java.util.Date;
import java.util.List;

import static utils.HLLUtils.addPrefix;
import static utils.HLLUtils.getLastDays;
import static utils.HLLUtils.getLastHours;

public class UVCounter {
    private Jedis client = JedisUtils.getClient();

    private static final String PREFIX = "USER:LOGIN:";

    public UVCounter() {

    }

    /**
     * 获取周UV
     *
     * @return UV数
     */
    public long getWeeklyUV() {
        List<String> suffixKeys = getLastDays(new Date(), 7);
        List<String> keys = addPrefix(suffixKeys, PREFIX);
        return client.pfcount(keys.toArray(new String[0]));
    }

    /**
     * 获取日UV
     *
     * @return UV数
     */
    public long getDailyUV() {
        List<String> suffixKeys = getLastHours(new Date(), 24);
        List<String> keys = addPrefix(suffixKeys, PREFIX);
        return client.pfcount(keys.toArray(new String[0]));
    }

    /**
     * 获取小时UV
     * 
     * @return UV数
     */
    public long getHourlyUV() {
        List<String> suffixKeys = getLastHours(new Date(), 1);
        List<String> keys = addPrefix(suffixKeys, PREFIX);
        return client.pfcount(keys.toArray(new String[0]));
    }
}
```

怎么样，你学会了吗？