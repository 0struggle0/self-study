# 目录

1. O(n²)排序
   1. [冒泡排序 Bubble Sort](https://quericy.me/blog/862/#冒泡排序-Bubble-Sort)
   2. [选择排序 Selection Sort](https://quericy.me/blog/862/#选择排序-Selection-Sort)
   3. [插入排序 Insertion Sort](https://quericy.me/blog/862/#插入排序-Insertion-Sort)
2. O(n log n)排序
   1. [归并排序 Merge Sort](https://quericy.me/blog/862/#归并排序-Merge-Sort)
   2. [快速排序 Quick Sort](https://quericy.me/blog/862/#快速排序-Quick-Sort)
3. O(n)排序
   1. [计数排序 Counting Sort](https://quericy.me/blog/862/#计数排序-Counting-Sort)
   2. [桶排序 Bucket Sort](https://quericy.me/blog/862/#桶排序-Bucket-Sort)
4. [参考链接](https://quericy.me/blog/862/#参考链接)

总算闲下来了，梳理了一下上个月面试相关的东西，发现以前收集的OneNote笔记里，算法这块记的比较凌乱，就把常见排序算法整理成MarkDown的，按时间复杂度区分，顺带写了Demo。嗯，还有，每个Demo的测试部分…仅供娱乐，因为shuffle出来的数组总是在best case和worst case之间，没有太大的实用性。

## O(n²)排序

### 冒泡排序 Bubble Sort

- best case: 顺序时，O(n)。worst case: 逆序时，O(n²)
- 依次比较相邻的两个数，然后根据大小做出排序，直至最后两位数
- 在排序过程中总是小数往前放，大数往后放
- 交换算法中，按位异或效率与临时变量相当但是异或更省空间
- 按位异或和临时变量交换的效率均大于php的`list($a,$b)=[$b,$a]`
- 按位异或的三个特点：
  1. 0^1=1 0^0=0 =>因此，0异或任何数等于任何数本身
  2. 1^0=1 1^1=0 =>因此，1异或任何数等于任何数取反
  3. 任何数异或自己=>把自己置0

```php
#冒泡排序
function bubble_sort($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        for ($k = $i + 1; $k < count($arr); $k++) {
            if ($arr[$i] > $arr[$k]) {
                bubble_swap($arr[$i], $arr[$k]);
            }
        }
    }
    return $arr;
}

function bubble_swap(&$a, &$b)
{
    //按位异或进行变量交换
    $a = $a ^ $b;
    $b = $a ^ $b;//(a^b)^b => a^(b^b) => a^1 => a
    $a = $b ^ $a;//a^(a^b) => (a^a)^b => 1^b => b
}

//Test(耗时370ms~460ms)
$a = array_rand(range(1, 3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
bubble_sort($a);  //排序
$t2 = microtime(true);
echo (($t2 - $t1) * 1000) . 'ms';
die;
```

### 选择排序 Selection Sort

- best case: O(n²)。worst case: O(n²)
- 遍历选出最小数放到开头，再从剩余未排序元素中继续寻找最小数放到已排序序列的末尾
- 不通过两两交换，而是记下最小数，偏移之后，把最小的数放回开头
- 由于两两交换的成本比偏移高，所以一般来说，选择排序比冒泡好
- 选择排序对右半边(unsorted)偏移

```php
#选择排序
function selection_sort($arr)
{
    $length = count($arr);
    for ($i = 0; $i < $length - 1; $i++) {
        //初始化最小数
        $min = $i;
        //找到未排序部分的最小数的序号
        for ($j = $i + 1; $j < $length; $j++) {
            if ($arr[$j] < $arr[$min]) $min = $j;
        }
        //不同则交换
        if ($min != $i) {
            selection_swap($arr[$i], $arr[$min]);
        }
    }
    return $arr;
}

function selection_swap(&$a, &$b)
{
    //按位异或进行变量交换
    $a = $a ^ $b;
    $b = $a ^ $b;
    $a = $b ^ $a;
}

//Test(耗时100~130ms)
$a = array_rand(range(1, 3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
selection_sort($a);  //排序
$t2 = microtime(true);
echo (($t2 - $t1) * 1000) . 'ms';
die;
```

### 插入排序 Insertion Sort

- best case: 顺序时，O(n)。worst case: 逆序时，O(n²)
- 选取一个数，保证这个数之前的数组已经排序好，把这个数插入到之前的数组中合适的位置
- 对于要插入的数据，在已排序序列中从后向前扫描
- 插入排序对左半边(sorted)偏移
- 插入排序只要找到左半边里合适的插入位置就能停下来，所以一般来说，它比选择排序好
- 算法步骤：
  1. 从第一个元素开始，该元素可以认为已经被排序
  2. 取出下一个元素，在已经排序的元素序列中从后向前扫描
  3. 如果该元素（已排序）大于新元素，将该元素移到下一位置
  4. 重复步骤3，直到找到已排序的元素小于或者等于新元素的位置
  5. 将新元素插入到该位置后，重复步骤2~5
- 示例图：

![插入排序过程](https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Insertion-sort-example-300px.gif/220px-Insertion-sort-example-300px.gif)

```php
#插入排序
function insertion_sort($arr)
{
    //首个元素视为已经排好序的
    for ($i = 1; $i < count($arr); $i++) {
        $value = $arr[$i];//取出元素值
        $index = $i - 1;//待插入的位置
        //当待插入的位置还有元素，且比取出的元素值大的时候
        while ($index >= 0 && $arr[$index] > $value) {
            //将待插入的位置的元素后移（即复值给后面的元素）
            $arr[$index + 1] = $arr[$index];
            //在待插入的位置继续向前搜寻
            $index--;
        }
        //前面发生过移动才插入
        if ($index != $i - 1) {
            //在最后插入的位置，插入取出的元素值
            $arr[$index + 1] = $value;
        }
    }
    return $arr;
}

//Test(耗时80~100ms)
$a = array_rand(range(1, 3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
insertion_sort($a);  //排序
$t2 = microtime(true);
echo (($t2 - $t1) * 1000) . 'ms';
die;
```

## O(n log n)排序

### 归并排序 Merge Sort

- best case: O(n logn)。worst case: O(n logn)
- arr长度<=1的时候，什么都不用做。
- 把arr对半分成left、right两个list，分别把left、right排序好。（递归）
- 最后，把排序好的left、right合并，按顺序放回arr里。

```php
#归并排序
function merge_sort($arr)
{
    //等同于count($arr) <= 1
    if (!isset($arr[1])) return $arr;
    //对半切割成两个数组
    $mid = intval(count($arr) / 2);
    $arr_left = array_slice($arr, 0, $mid);
    $arr_right = array_slice($arr, $mid);
    //分治法，递归切割以及合并
    return merge(merge_sort($arr_left), merge_sort($arr_right));
}

function merge($arr_left, $arr_right)
{
    $combine_arr = [];
    //取最小的，放入合并数组中
    while (isset($arr_left[0]) && isset($arr_right[0])) {
        $combine_arr[] = ($arr_left[0] <= $arr_right[0]) ? array_shift($arr_left) : array_shift($arr_right);
    }
    //排完left或right其中一个，由于递归保证剩下的有序，对剩下的进行合并追加
    return array_merge($combine_arr, $arr_left, $arr_right);
}

//Test(耗时25ms~48ms)
$a = array_rand(range(1,3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
merge_sort($a);  //排序
$t2 = microtime(true);
echo (($t2-$t1)*1000).'ms';
die;
```

### 快速排序 Quick Sort

- best case: O(n logn)。worst case: O(n²)
- 先对数组进行分割， 把大的元素数值放到一个临时数组里，把小的元素数值放到另一个临时数组里
- 这个分割的点可以是数组中的任意一个元素值，一般用第一个元素
- 递归地把这两个临时数组重复上面拆分
- 最后把小的数组元素和大的数组元素合并起来

```php
#快速排序
function quick_sort($arr)
{
    if (!isset($arr[1])) return $arr;
    //取出首个元素作为分割关键字
    $mid = array_shift($arr);
    $left_arr = $right_arr = array();
    foreach ($arr as $each) {
        //遍历，对比关键字大小划分到两个数组
        ($each <= $mid) ? ($left_arr[] = $each) : ($right_arr[] = $each);
    }
    //递归合并
    return array_merge(quick_sort($left_arr), array($mid), quick_sort($right_arr));
}

//Test(耗时8~20ms)
$a = array_rand(range(1,3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
quick_sort($a);  //排序
$t2 = microtime(true);
echo (($t2-$t1)*1000).'ms';
die;
```

## O(n)排序

- 通过两数字比较的排序最快也需要O(n logn)，O(n)的排序都不通过两数比较来排序

### 计数排序 Counting Sort

- O(n)，稳定的线性时间排序算法。不是比较排序，排序的速度快于任何比较排序算法
- 对于数据范围很大的数组，需要大量时间和内存
- 属于桶排序的特殊情况
- 使用一个额外的数组，其中第`i`个元素是待排序数组里，值等于i的元素的个数
- 算法步骤：
  1. 找出待排序的数组中最大和最小的元素
  2. 统计数组中每个值为*i*的元素出现的次数，存入数组 *C* 的第 *i* 项
  3. 对所有的计数累加（从*C*中的第一个元素开始，每一项和前一项相加）
  4. 反向填充目标数组：将每个元素*i*放在新数组的第*C(i)*项，每放一个元素就将*C(i)*减去1

```php
#计数排序
function counting_sort($arr)
{
    $length = count($arr);
    if ($length <= 1) return $arr;
    //找出最大值最小值
    $min=min($arr);
    $max=max($arr);
    //创建计数器(这里不用array_fill因为其无法创建多个负值的键名)
    $count_arr = array();
    for ($i = $min; $i <= $max; $i++) {
        $count_arr[$i] = 0;
    }
    //进行计数，得到等于计数器键名的数有多少个
    foreach ($arr as $each) {
        $count_arr[$each]++;
    }
    //相邻计数，得到小于等于计数器键名的数有多少个
    for ($i = $min + 1; $i <= $max; $i++) {
        $count_arr[$i] += $count_arr[$i - 1];
    }
    //数组翻转,由计数器决定了每个元素在第几个
    $flip_arr = array();
    for ($i = $length - 1; $i >= 0; $i--) {
        $flip_arr[$count_arr[$arr[$i]]] = $arr[$i];
        //每找到一个数，该键计数器减1，给相同大小的数预留位置(即有重复时的特殊处理)
        $count_arr[$arr[$i]]--;
    }
    //将翻转数组整理为顺序
    for ($i = 1; $i <= $length; $i++) {
        $return_arr[] = $flip_arr[$i];
    }
    return $return_arr;
}

//Test(耗时1~6ms)
$a = array_rand(range(1, 3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
counting_sort($a);  //排序
$t2 = microtime(true);
echo (($t2 - $t1) * 1000) . 'ms';
die;
```

### 桶排序 Bucket Sort

- 线性时间O(n)。桶排序不是比较排序，不受O(n log n)下限的影响。
- 桶排序比计数排序简单，只是桶中元素不能顺序放入和顺序取出
- 桶越多，时间效率就越高，空间占用却越大。
- 因此范围很大时，也可以设计成：按区间划分进桶，在桶里对每个元素排序(随便什么排序算法都行)，再依次收集桶里的元素
- 算法步骤：
  1. 设置一个定量的数组当作空桶。
  2. 寻访序列，并且把项目一个一个放到对应的桶去。
  3. 对每个不是空的桶进行排序。
  4. 从不是空的桶里把项目再放回原来的序列中。

```php
#桶排序（特殊实现）
function bucket_sort($arr)
{
    $length = count($arr);
    if ($length <= 1) return $arr;
    $min = min($arr);
    $max = max($arr);
    //创建桶(这里不用array_fill因为其无法创建多个负值的键名)
    for ($i = $min; $i <= $max; $i++) {
        $bucket_arr[$i] = 0;
    }
    //分配桶
    foreach ($arr as $each) {
        $bucket_arr[$each]++;
    }
    $return_arr = array();
    //按顺序从每个桶里取出
    foreach ($bucket_arr as $each => $each_count) {
        //桶里有元素的，依次收集
        for ($i = 1; $i <= $each_count; $i++) {
            $return_arr[] = $each;
        }
    }
    return $return_arr;
}

//Test(耗时1~10ms)
$a = array_rand(range(1, 3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
bucket_sort($a);  //排序
$t2 = microtime(true);
echo (($t2 - $t1) * 1000) . 'ms';
die;
```

```php
#桶排序（常规实现）
function bucket_sort($arr,$chunk = 10)
{
    $length = count($arr);
    if ($length <= 1) {
        return $arr;
    }
    //初始化桶
    $min = floor(min($arr) / $chunk);
    $max = ceil(max($arr) / $chunk);
    $bucket_arr = array();
    for ($i = $min; $i <= $max; $i++) {
        $bucket_arr[$i] = array();
    }
    //按区间填充桶
    foreach ($arr as $each) {
        if ($each >= 0) {
            array_push($bucket_arr[ceil($each / $chunk)], $each);
        } else {
            array_push($bucket_arr[floor($each / $chunk)], $each);
        }
    }
    //从桶里取出
    $return_arr = array();
    foreach ($bucket_arr as $bucket) {
        if (!empty($bucket)) {
            //对每个桶内的元素进行排序,这里用了快排
            $each_arr = quick_sort($bucket);
            foreach ($each_arr as $each) {
                $return_arr[] = $each;
            }
        }
    }
    return $return_arr;
}

function quick_sort($arr)
{
    if (!isset($arr[1])) return $arr;
    $mid = array_shift($arr);
    $left_arr = $right_arr = array();
    foreach ($arr as $each) {
        $each < $mid ? ($left_arr[] = $each) : ($right_arr[] = $each);
    }
    return array_merge(quick_sort($left_arr), array($mid), quick_sort($right_arr));
}

//Test(耗时3~10ms)
$a = array_rand(range(1, 3000), 1500);
shuffle($a);  //获取已经打乱了顺序的数组
$t1 = microtime(true);
bucket_sort($a);  //排序
$t2 = microtime(true);
echo (($t2 - $t1) * 1000) . 'ms';
die;
```

