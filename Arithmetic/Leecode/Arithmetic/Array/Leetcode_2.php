<?php

#***************************************************************************************************************************
# 1. 猜数字
// 小A 和 小B 在玩猜数字。小B 每次从 1, 2, 3 中随机选择一个，小A 每次也从 1, 2, 3 中选择一个猜。他们一共进行三次这个游戏，请返回 小A 猜对了几次？
// 输入的guess数组为 小A 每次的猜测，answer数组为 小B 每次的选择。guess和answer的长度都等于3。

// 示例 1：
// 输入：guess = [1,2,3], answer = [1,2,3]
// 输出：3
// 解释：小A 每次都猜对了。

// 示例 2：
// 输入：guess = [2,2,3], answer = [3,2,1]
// 输出：1
// 解释：小A 只猜对了第二次。

// 限制：
// guess的长度 = 3
// answer的长度 = 3
// guess的元素取值为 {1, 2, 3} 之一。
// answer的元素取值为 {1, 2, 3} 之一。
#***************************************************************************************************************************

// $array1 = array(1, 2, 3);
// $array2 = array(1, 2, 3);

// 方法一
// $result = count(array_intersect_assoc($array1, $array2));

// 方法二  只适用于知道规模小的数据且有限
// $result = ($array1[0]==$array2[0]?1:0)+($array1[1]==$array2[1]?1:0)+($array1[2]==$array2[2]?1:0);
// var_dump($result);



#***************************************************************************************************************************
# 2. 多数元素 编号(编号 #169)
// 给定一个大小为 n 的数组，找到其中的多数元素。多数元素是指在数组中出现次数大于 ⌊ n/2 ⌋ 的元素。
// 你可以假设数组是非空的，并且给定的数组总是存在多数元素。

// 示例 1:
// 输入: [3,2,3]
// 输出: 3

// 示例 2:
// 输入: [2,2,1,1,1,2,2]
// 输出: 2

// 本题题面中没有给出数据范围，但最简单的暴力方法（即枚举数组中的每个元素，再遍历一遍数组统计其出现次数，时间复杂度为 O(N^2)的算法）会超出时间限制，因此我们需要找出时间复杂度小于 O(N^2) 的优秀做法。
#***************************************************************************************************************************

// 方法一：哈希表
// 思路
// 我们知道出现次数最多的元素大于n/2次，所以可以用哈希表来快速统计每个元素出现的次数。

// 算法
// 我们使用哈希映射来存储每个元素以及出现的次数。对于哈希映射中的每个键值对，键表示一个元素，值表示该元素出现的次数。
// 我们用一个循环遍历数组 nums 并将数组中的每个元素加入哈希映射中。在这之后，我们遍历哈希映射中的所有键值对，返回值最大的键。我们同样也可以在遍历数组 nums 时候使用打擂台的方法，维护最大的值，这样省去了最后对哈希映射的遍历。

function majorityElement($nums) 
{
    $half = floor(count($nums) / 2);
    $counts = countNums($nums);
    foreach ($counts as $element => $time) {
        if ($time > $half) {
            return $element;
        }
    }
}

function countNums($nums)
{
    $hash = [];
    foreach ($nums as $num) {
        if (array_key_exists($num, $hash)) {
            $hash[$num] += 1;
        } else {
            $hash[$num] = 1;
        }
    }
    return $hash;
}

// 方法二：排序
// 思路
// 如果将数组 nums 中的所有元素按照单调递增或单调递减的顺序排序，那么下标为 n/2 的元素（下标从 0 开始）一定是众数。

// 算法
// 对于这种算法，我们先将 nums 数组排序，然后返回上文所说的下标对应的元素。下面的图中解释了为什么这种策略是有效的。在下图中，第一个例子是 nn 为奇数的情况，第二个例子是 nn 为偶数的情况。
// function majorityElement($nums) 
// {
//     sort($nums);
//     $length = count($nums);
//     return $nums[$length / 2];
// }



// function majorityElement($nums) 
// {
//     $countValues = array_count_values($nums);
//     $maxValueIndex = array_search(max($countValues), $countValues);
//     return $maxValueIndex;
// }

// $array = [3,2,3];
// $array = [2,2,1,1,1,2,2];
// var_dump(majorityElement($array));

#***************************************************************************************************************************
# 3. 移动零 (#编号283)
// 给定一个数组 nums，编写一个函数将所有 0 移动到数组的末尾，同时保持非零元素的相对顺序。

// 示例:
// 输入: [0,1,0,3,12]
// 输出: [1,3,12,0,0]

// 说明:
// 必须在原数组上操作，不能拷贝额外的数组。
// 尽量减少操作次数。
#***************************************************************************************************************************

// 这个问题属于 “数组变换” 的一个广泛范畴。这一类是技术面试的重点。主要是因为数组是如此简单和易于使用的数据结构。
// 遍历或表示不需要任何样板代码，而且大多数代码将看起来像伪代码本身。

// 问题的两个要求是：
// 将所有 0 移动到数组末尾。
// 所有非零元素必须保持其原始顺序。
// 这里很好地认识到这两个需求是相互排斥的，也就是说，你可以解决单独的子问题，然后将它们组合在一起以得到最终的解决方案。

// 方法一 self 不符合要求 “必须在原数组上操作，不能拷贝额外的数组”
// function moveZeroes(&$nums)
// {
//     if (empty($nums)) {
//         return false;
//     }

//     $bigArray = [];
//     $zeroArray = [];
//     foreach ($nums as $value) {
//         if ($value == 0) {
//             $zeroArray[] = $value;
//         } else {
//             $bigArray[] = $value;
//         }
//     }
//     $nums = array_merge($bigArray, $zeroArray);
// }

// 方法二 空间最优，操作局部优化（快慢双指针）
// 利用两次遍历，我们创建两个指针i和j，第一次遍历的时候指针j用来记录当前有多少非0元素。即遍历的时候每遇到一个非0元素就将其往数组左边挪，
// 第一次遍历完后，j指针的下标就指向了最后一个非0元素下标。第二次遍历的时候，起始位置就从j开始到结束，将剩下的这段区域内的元素全部置为0。
function moveZeroes(&$nums)
{
    if (empty($nums)) {
        return false;
    }

    $j = 0;
    $countNum = count($nums);
    for ($i = 0; $i < $countNum; $i++) { 
        if ($nums[$i] != 0) {
            $nums[$j++] = $nums[$i];
        }
    }

    for ($i = $j; $i < $countNum; $i++) { 
        $nums[$i] = 0;
    }
}
// 复杂度分析:
// 时间复杂度：O(n)。但是，操作仍然是局部优化的。代码执行的总操作（数组写入）为 n（元素总数）。
// 空间复杂度：O(1)，只使用常量空间。

// 一次遍历
// 这里参考了快速排序的思想，快速排序首先要确定一个待分割的元素做中间点x，然后把所有小于等于x的元素放到x的左边，大于x的元素放到其右边。
// 这里我们可以用0当做这个中间点，把不等于0(注意题目没说不能有负数)的放到中间点的左边，等于0的放到其右边。
// 这的中间点就是0本身，所以实现起来比快速排序简单很多，我们使用两个指针i和j，只要nums[i]!=0，我们就交换nums[i]和nums[j]
// function moveZeroes(&$nums)
// {
//     if (empty($nums)) {
//         return false;
//     }

//     $j = 0;
//     $countNum = count($nums);
//     for ($i = 0; $i < $countNum; $i++) { 
//         // 当前元素!=0，就把其交换到左边，等于0的交换到右边
//         if ($nums[$i] != 0) {
//             $temp = $nums[$i];
//             $nums[$i] = $nums[$j];
//             $nums[$j++] = $temp;
//         }
//     }
// }

// $array = [0,1,0,3,12];
// moveZeroes($array);
// var_dump($array);


#***************************************************************************************************************************
# 4. 总持续时间可被 60 整除的歌曲(#编号1010)
// 在歌曲列表中，第 i 首歌曲的持续时间为 time[i] 秒。
// 返回其总持续时间（以秒为单位）可被 60 整除的歌曲对的数量。形式上，
// 我们希望索引的数字 i 和 j 满足  i < j 且有 (time[i] + time[j]) % 60 == 0。

// 示例 1：
// 输入：[30,20,150,100,40]
// 输出：3

// 解释：这三对的总持续时间可被 60 整数：
// (time[0] = 30, time[2] = 150): 总持续时间 180
// (time[1] = 20, time[3] = 100): 总持续时间 120
// (time[1] = 20, time[4] = 40): 总持续时间 60

// 示例 2：
// 输入：[60,60,60]
// 输出：3

// 解释：所有三对的总持续时间都是 120，可以被 60 整数。
 
// 提示：
// 1 <= time.length <= 60000
// 1 <= time[i] <= 500
#***************************************************************************************************************************

// 整数对60取模，可能有60种余数。故初始化一个长度为60的数组，统计各余数出现的次数。
// 遍历time数组，每个值对60取模，并统计每个余数值（0-59）出现的个数。因为余数部分需要找到合适的cp组合起来能被60整除。
// 余数为0的情况，只能同余数为0的情况组合（如60s、120s等等）。0的情况出现k次，则只能在k中任选两次进行两两组合。
// 本题解单独写了个求组合数的方法，也可以用k * (k - 1) / 2表示。
// 余数为30的情况同上。
// 其余1与59组合，2与58组合，故使用双指针分别从1和59两头向中间遍历。1的情况出现m次，59的情况出现n次，则总共有m*n种组合。

// 运行超时
// function numPairsDivisibleBy60($time) 
// {
//     if (empty($time)) {
//         return false;
//     }

//     $count = 0;
//     $timeLength = count($time);
//     for ($startIndex = 0; $startIndex < $timeLength; $startIndex++) {
//         for ($backIndex = $startIndex + 1; $backIndex < $timeLength; $backIndex++) {
//             if (($time[$startIndex] + $time[$backIndex]) % 60 == 0) {
//                 $count++;
//             }
//         }
//     }
//     return $count;
// }

function numPairsDivisibleBy60($time) 
{
    if (empty($time)) {
        return false;
    }

    $countNumbers = [];
    foreach ($time as $value) {
        $remainder = $value % 60;
        if (isset($countNumbers[$remainder])) {
            $countNumbers[$remainder] += 1;
        } else {
            $countNumbers[$remainder] = 1;
        }
    }
    
    $resultCount = 0;
    $length = count($countNumbers);
    for ($startIndex = 0; $startIndex < $length; $startIndex++) {
        if ($countNumbers[$startIndex] == 0) {
            continue;
        }

        if ($startIndex == 0 || $startIndex == 30) {
            $resultCount += $countNumbers[$startIndex] * ($countNumbers[$startIndex] - 1);
        } else {
            $resultCount += $countNumbers[$startIndex] * (!isset($countNumbers[60 - $startIndex])) ? 0 : $countNumbers[60 - $startIndex];
        }
    }

    return $resultCount / 2;
}

$time = [30,20,150,100,40];
var_dump(numPairsDivisibleBy60($time));