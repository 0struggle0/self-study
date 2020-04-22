# 什么是 UUID ?

**UUID** 是指Universally Unique Identifier，翻译为中文是**通用唯一识别码**，UUID 的目的是让分布式系统中的所有元素都能有唯一的识别信息。如此一来，每个人都可以创建不与其它人冲突的 UUID，就不需考虑数据库创建时的名称重复问题。

UUID 的目的，是让分布式系统中的所有元素，都能有唯一的辨识资讯，而不需要透过中央控制端来做辨识资讯的指定。如此一来，每个人都可以建立不与其它人冲突的 UUID。在这样的情况下，就不需考虑数据库建立时的名称重复问题。目前最广泛应用的 UUID，即是微软的 Microsoft's Globally Unique Identifiers (GUIDs)，而其他重要的应用，则有 Linux ext2/ext3 档案系统、LUKS 加密分割区、GNOME、KDE、Mac OS X 等等。
UUID是指在一台机器上生成的数字，它保证对在同一时空中的所有机器都是唯一的。通常平台会提供生成的API。按照开放软件基金会(OSF)制定的标准计算，用到了以太网卡地址、纳秒级时间、芯片ID码和许多可能的数字
UUID由以下几部分的组合：
（1）当前日期和时间，UUID的第一个部分与时间有关，如果你在生成一个UUID之后，过几秒又生成一个UUID，则第一个部分不同，其余相同。
（2）时钟序列。
（3）全局唯一的IEEE机器识别号，如果有网卡，从网卡MAC地址获得，没有网卡以其他方式获得。
UUID的唯一缺陷在于生成的结果串会比较长。关于UUID这个标准使用最普遍的是微软的GUID(Globals Unique Identifiers)。在ColdFusion中可以用CreateUUID()函数很简单地生成UUID，其格式为：xxxxxxxx-xxxx- xxxx-xxxxxxxxxxxxxxxx(8-4-4-16)，其中每个 x 是 0-9 或 a-f 范围内的一个十六进制的数字。
而 标准的UUID格式为：xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxx (8-4-4-4-12)，可以从cflib 下载CreateGUID() UDF进行转换。

> 定义

UUID 是由一组32位数的16进制数字所构成，是故 UUID 理论上的总数为1632=2128，约等于3.4 x 10123。

也就是说若每纳秒产生1百万个 UUID，要花100亿年才会将所有 UUID 用完

> 格式

UUID 的十六个八位字节被表示为 32个十六进制数字，以连字号分隔的五组来显示，形式为 8-4-4-4-12，总共有 36个字符（即三十二个英数字母和四个连字号）。例如：

```
123e4567-e89b-12d3-a456-426655440000
xxxxxxxx-xxxx-Mxxx-Nxxx-xxxxxxxxxxxx
```

数字 `M`的四位表示 UUID 版本，当前规范有5个版本，M可选值为`1, 2, 3, 4, 5` ；

数字 `N`的一至四个最高有效位表示 UUID 变体( variant )，有固定的两位`10xx`因此只可能取值`8, 9, a, b`

UUID版本通过M表示，当前规范有5个版本，M可选值为`1, 2, 3, 4, 5`。这5个版本使用不同算法，利用不同的信息来产生UUID，各版本有各自优势，适用于不同情景。具体使用的信息

- version 1, date-time & MAC address
- version 2, date-time & group/user id
- version 3, MD5 hash & namespace
- version 4, pseudo-random number
- version 5, SHA-1 hash & namespace

使用较多的是版本1和版本4，其中版本1使用当前时间戳和MAC地址信息。版本4使用(伪)随机数信息，128bit中，除去版本确定的4bit和variant确定的2bit，其它122bit全部由(伪)随机数信息确定。

因为时间戳和随机数的唯一性，版本1和版本4总是生成唯一的标识符。若希望对给定的一个字符串总是能生成相同的 UUID，使用版本3或版本5。

> 随机 UUID 的重复机率

Java中 UUID 使用版本4进行实现，所以由[java.util.UUID](http://java.sun.com/javase/6/docs/api/java/util/UUID.html)类产生的 UUID，128个比特中，有122个比特是随机产生，4个比特标识版本被使用，还有2个标识变体被使用。利用[生日悖论](https://zh.wikipedia.org/wiki/生日悖論)，可计算出两笔 UUID 拥有相同值的机率约为



![img](https:////upload-images.jianshu.io/upload_images/3274507-3d3f3ea419fa5981.jpg?imageMogr2/auto-orient/strip|imageView2/2/w/165/format/webp)



其中`x`为 UUID 的取值范围，`n`为 UUID 的个数。

以下是以 x = 2122 计算出n笔 UUID 后产生碰撞的机率：

| n                        | 机率                           |
| ------------------------ | ------------------------------ |
| 68,719,476,736 = 236     | 0.0000000000000004 (4 x 10-16) |
| 2,199,023,255,552 = 241  | 0.0000000000004 (4 x 10-13)    |
| 70,368,744,177,664 = 246 | 0.0000000004 (4 x 10-10)       |

换句话说，每秒产生10亿笔 UUID ，100年后*只产生一次*重复的机率是50%。如果地球上每个人都各有6亿笔 UUID，发生一次重复的机率是50%。与被陨石击中的机率比较的话，已知一个人每年被陨石击中的机率估计为170亿分之1，也就是说机率大约是0.00000000006 (6 x 10-11)，等同于在一年内生产2000亿个 UUID 并发生一次重复。

综上所述，产生重复 UUID 并造成错误的情况非常低，是故大可不必考虑此问题。

机率也与随机数产生器的质量有关。若要避免重复机率提高，必须要使用基于密码学上的**强伪随机数产生器**来生成值才行。

# 二. 生成方法

## 1.使用函数uuid_create()函数或者com_create_guid()

使用uuid_create()函数前需要先安装uuid扩展, 安装方法如下

http://www.bubuko.com/infodetail-2390379.html(转载)



## 2.自定义函数

```php
`if` `(!function_exists(``'com_create_guid'``)) {`` ``function` `com_create_guid() {``  ``return` `sprintf( ``'%04x%04x-%04x-%04x-%04x-%04x%04x%04x'``,``    ``mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),``    ``mt_rand( 0, 0xffff ),``    ``mt_rand( 0, 0x0fff ) | 0x4000,``    ``mt_rand( 0, 0x3fff ) | 0x8000,``    ``mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )``  ``);`` ``}``}`
```



> Java实现

Java中 UUID 对版本4进行了实现，原理是由强伪随机数生成器生成伪随机数。



```java
    /**
     * 使用静态工厂来获取版本4（伪随机数生成器）的 UUID
     * Static factory to retrieve a type 4 (pseudo randomly generated) UUID.
     * 这个UUID生成使用了强加密的伪随机数生成器(PRNG)
     * The {@code UUID} is generated using a cryptographically strong pseudo
     * random number generator.
     *
     * @return  A randomly generated {@code UUID}
     */
    public static UUID randomUUID() {
        // 与Random(弱伪随机数生成器)不一样，SecureRandom是强伪随机数生成器，结果不可预测
        // 使用SecureRandom生成随机数，替换version和variant就是 UUID
        SecureRandom ng = Holder.numberGenerator;

        byte[] randomBytes = new byte[16];
        ng.nextBytes(randomBytes);
        randomBytes[6]  &= 0x0f;  /* clear version        */
        randomBytes[6]  |= 0x40;  /* set to version 4     */
        randomBytes[8]  &= 0x3f;  /* clear variant        */
        randomBytes[8]  |= 0x80;  /* set to IETF variant  */
        return new UUID(randomBytes);
    }

    /**
     * 对版本3的实现，对于给定的字符串（name）总能生成相同的UUID
     * Static factory to retrieve a type 3 (name based) {@code UUID} based on
     * the specified byte array.
     *
     * @param  name
     *         A byte array to be used to construct a {@code UUID}
     *
     * @return  A {@code UUID} generated from the specified array
     */
    public static UUID nameUUIDFromBytes(byte[] name) {
        MessageDigest md;
        try {
            md = MessageDigest.getInstance("MD5");
        } catch (NoSuchAlgorithmException nsae) {
            throw new InternalError("MD5 not supported", nsae);
        }
        byte[] md5Bytes = md.digest(name);
        md5Bytes[6]  &= 0x0f;  /* clear version        */
        md5Bytes[6]  |= 0x30;  /* set to version 3     */
        md5Bytes[8]  &= 0x3f;  /* clear variant        */
        md5Bytes[8]  |= 0x80;  /* set to IETF variant  */
        return new UUID(md5Bytes);
    }
```

> 生成 UUID



```java
// Java语言实现
import java.util.UUID;

public class UUIDProvider{
    public static String getUUID(){
        return UUID.randomUUID().toString().replaceAll("-", "");
    }
    public static void main(String[] args) {
        // 利用伪随机数生成版本为4,变体为9的UUID
        System.out.println(UUID.randomUUID());
        
        // 对于相同的命名空间总是生成相同的UUID,版本为3,变体为9
        // 命名空间为"mwq"时生成的UUID总是为06523e4a-9a66-3687-9334-e41dab27cef4
        System.out.println(UUID.nameUUIDFromBytes("mwq".getBytes()));
    }
} 
```

> 待补充

snowflake算法
 guid
 varient
 SecureRandom 版本4的UUID生成原理，与Random的区别等
 https://resources.infosecinstitute.com/random-number-generation-java/
 https://www.saowen.com/a/d2f3430d15558a740d95b76ff04b242d59b08ea44847ff5941a9ded0e08a65c1
 http://yizhenn.iteye.com/blog/2306293
 mysql UUID
 https://dev.mysql.com/doc/refman/8.0/en/miscellaneous-functions.html#function_uuid
 [Leaf——美团点评分布式ID生成系统](https://tech.meituan.com/MT_Leaf.html)

参考链接:

https://www.ietf.org/rfc/rfc4122.txt

https://www.zhihu.com/question/34876910/answer/88924223

https://en.wikipedia.org/wiki/Universally_unique_identifier#Encoding