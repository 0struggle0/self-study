<?php

#***************************************************************************************************************************
# 1. 两数之和(编号 #1)
// 给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那两个整数，并返回他们的数组下标。
// 你可以假设每种输入只会对应一个答案。但是，你不能重复利用这个数组中同样的元素。
// 示例:
// 给定 nums = [2, 7, 11, 15], target = 9
// 因为 nums[0] + nums[1] = 2 + 7 = 9
// 所以返回 [0, 1]
#***************************************************************************************************************************

// 解法一 (暴力破解)  时间复杂度O(n^2)  空间复杂度O(1)
// function twoSum($nums, $target) {
//     foreach ($nums as $key => $num) {
//         foreach ($nums as $keyBak => $numBak) {
//             if ($key != $keyBak && ($num + $numBak == $target)) {
//                 return array($key, $keyBak);
//             }
//         }
//     }
// }

// 解法二 时间复杂度降为O(n)，这种写法会避免键值丢失的问题，但是如果遇到有多个相同键值时，只会返回第一个键值的索引
// function twoSum($nums, $target)
// {
//     $find = [];
//     foreach ($nums as $index => $value) {
//         $otherIndex = array_keys($find, ($target - $value));

//         if ($otherIndex) {
//             return [$otherIndex[0], $index];
//         }

//         $find[$index] = $value;
//     }
// }

// 方法三 如果数组中没有重复值，没有零可以使用哈希结构，时间复杂度变为O(N), 取值会变为O(1)
function twoSum($nums, $target)
{
    $find = [];
    foreach ($nums as $index => $value) {
        $remainder = $target - $value;
        if (isset($find[$remainder])) {
            return [$find[$remainder], $index];
        }
        $find[$value] = $index;
    }
}

// var_dump(twoSum(array(3, 2, 4), 6));

#***************************************************************************************************************************
# 2. 两数之和 II - 输入有序数组 (编号 #167)
// 给定一个已按照升序排列 的有序数组，找到两个数使得它们相加之和等于目标数。
// 函数应该返回这两个下标值 index1 和 index2，其中 index1 必须小于 index2。

// 说明:
// 返回的下标值（index1 和 index2）不是从零开始的。
// 你可以假设每个输入只对应唯一的答案，而且你不可以重复使用相同的元素。

// 示例1:
// 输入: numbers = [2, 7, 11, 15], target = 9
// 输出: [1,2]
// 解释: 2 与 7 之和等于目标数 9 。因此 index1 = 1, index2 = 2 。

// 示例2:
// 输入: numbers = [0, 0, 3, 4], target = 0
// 输出: [1,2]
// 解释: 0 与 0 之和等于目标数 0 。因此 index1 = 1, index2 = 2 。

#***************************************************************************************************************************

// 方法一
// function twoSum($numbers, $target)
// {
//     $result = [];
//     $numbersCount = count($numbers);
//     for ($i = 0; $i < $numbersCount; $i++) {
//         $index = array_search($target - $numbers[$i], $numbers);
//         if ($index !== false && $index != $i) {
//             $result[] = min($i, $index) + 1;
//             $result[] = max($i, $index) + 1;
//             return $result;
//         }
//     }

//     return $result;
// }

// 方法二 双指针法
// 针对输入数组已经排序的性质，可以采用双指针
// 使用两个指针，初始分别位于第一个元素和最后一个元素位置，比较这两个元素之和与目标值的大小。如果和等于目标值，我们发现了这个唯一解。
// 如果比目标值小，我们将较小元素指针增加一。如果比目标值大，我们将较大指针减小一。移动指针后重复上述比较知道找到答案。

// 假设 [... , a, b, c, ... , d, e, f, …]是已经升序排列的输入数组，并且元素 b, e 是唯一解。因为我们从左到右
// 移动较小指针，从右到左移动较大指针，总有某个时刻存在一个指针移动到 bb 或 ee 的位置。不妨假设小指针县移动到了元素 bb ，这是两个元素的和一定
// 比目标值大，根据我们的算法，我们会向左移动较大指针直至获得结果。

// 使用双指针，一个指针指向值较小的元素，一个指针指向值较大的元素。指向较小元素的指针从头向尾遍历，指向较大元素的指针从尾向头遍历。
// 如果两个指针指向元素的和 sum == targetsum==target，那么得到要求的结果；
// 如果 sum > targetsum>target，移动较大的元素，使 sumsum 变小一些；
// 如果 sum < targetsum<target，移动较小的元素，使 sumsum 变大一些。
// 数组中的元素最多遍历一次，时间复杂度为 O(N)。只使用了两个额外变量，空间复杂度为 O(1)。

// function twoSum($numbers, $target)
// {
//     $left = 0;
//     $right = count($numbers) - 1;
//     while ($left < $right) {
//         if ($numbers[$left] + $numbers[$right] == $target) {
//             return [$left + 1, $right + 1];
//         } else if ($numbers[$left] + $numbers[$right] > $target) {
//             $right--;
//         } else {
//             $left++;
//         }
//     }
//     return [0, 0];
// }

// var_dump(twoSum([3, 2, 1, 1], 2));

#***************************************************************************************************************************
# 3. 删除排序数组中的重复项(编号 #26)
// 给定一个排序数组，你需要在原地删除重复出现的元素，使得每个元素只出现一次，返回移除后数组的新长度。
// 不要使用额外的数组空间，你必须在原地修改输入数组并在使用 O(1) 额外空间的条件下完成。

// 示例 1:
// 给定数组 nums = [1,1,2], 
// 函数应该返回新的长度 2, 并且原数组 nums 的前两个元素被修改为 1, 2。 
// 你不需要考虑数组中超出新长度后面的元素。

// 示例 2:
// 给定 nums = [0,0,1,1,1,2,2,3,3,4],
// 函数应该返回新的长度 5, 并且原数组 nums 的前五个元素被修改为 0, 1, 2, 3, 4。
// 你不需要考虑数组中超出新长度后面的元素。

// 说明:
// 为什么返回数值是整数，但输出的答案是数组呢?
// 请注意，输入数组是以“引用”方式传递的，这意味着在函数里修改输入数组对于调用者是可见的。
// 你可以想象内部操作如下:
// nums 是以“引用”方式传递的。也就是说，不对实参做任何拷贝
// int len = removeDuplicates(nums);

// 在函数里修改输入数组对于调用者是可见的。
// 根据你的函数返回的长度, 它会打印出数组中该长度范围内的所有元素。
// for (int i = 0; i < len; i++) {
//     print(nums[i]);
// }
#***************************************************************************************************************************

// self(一) 调用系统方法
// function removeDuplicates(&$nums) 
// {
//     $nums = array_flip(array_flip($nums));
//     var_dump($nums);
//     return count($nums);
// }

// 执行结果：通过
// 执行用时 : 24 ms, 在所有 php 提交中击败了87.88%的用户
// 内存消耗 : 17 MB, 在所有 php 提交中击败了21.35%的用户

// self(二) 调用系统方法
// function removeDuplicates(&$nums) 
// {
//     $nums = array_unique($nums);
//     return count($nums);
// }

// 执行结果：通过
// 执行用时 : 24 ms, 在所有 php 提交中击败了87.88%的用户
// 内存消耗 : 17.3 MB, 在所有 php 提交中击败了15.73%的用户

// 算法思路：双指针：分为快慢指针
// 复杂度分析
// 时间复杂度：O(n)，假设数组的长度是 n，那么 i 和 j 分别最多遍历 n 步。
// 空间复杂度：O(1)。
// function removeDuplicates(&$nums) 
// {
//     $length = count($nums);
//     if ($length == 0) {
//         return 0;
//     }

//     $i = 0;
//     for ($j = 1; $j < $length; $j++) {
//         if ($nums[$j] != $nums[$i]) {
//             $i++;
//             $nums[$i] = $nums[$j];
//         }
//     }

//     return $i + 1;
// }

// 执行结果：通过
// 执行用时 : 24 ms, 在所有 php 提交中击败了87.88%的用户
// 内存消耗 : 16.8 MB, 在所有 php 提交中击败了15.73%的用户

// $nums = array(0,0,1,1,1,2,2,3,3,4);
// var_dump(removeDuplicates($nums));

#***************************************************************************************************************************
# 4. 移除元素(编号 #27)
// 给定一个数组 nums 和一个值 val，你需要原地移除所有数值等于 val 的元素，返回移除后数组的新长度。
// 不要使用额外的数组空间，你必须在原地修改输入数组并在使用 O(1) 额外空间的条件下完成。
// 元素的顺序可以改变。你不需要考虑数组中超出新长度后面的元素。

// 示例 1:
// 给定 nums = [3,2,2,3], val = 3,
// 函数应该返回新的长度 2, 并且 nums 中的前两个元素均为 2。
// 你不需要考虑数组中超出新长度后面的元素。

// 示例 2:
// 给定 nums = [0,1,2,2,3,0,4,2], val = 2,
// 函数应该返回新的长度 5, 并且 nums 中的前五个元素为 0, 1, 3, 0, 4。
// 注意这五个元素可为任意顺序。
// 你不需要考虑数组中超出新长度后面的元素。

// 说明:
// 为什么返回数值是整数，但输出的答案是数组呢?
// 请注意，输入数组是以“引用”方式传递的，这意味着在函数里修改输入数组对于调用者是可见的。
// 你可以想象内部操作如下:
// nums 是以“引用”方式传递的。也就是说，不对实参作任何拷贝
// int len = removeElement(nums, val);

// 在函数里修改输入数组对于调用者是可见的。
// 根据你的函数返回的长度, 它会打印出数组中该长度范围内的所有元素。
// for (int i = 0; i < len; i++) {
//     print(nums[i]);
// }

#***************************************************************************************************************************

// self(一) 调用系统方法
// function removeElement(&$nums, $val)
// {
//     if (empty($nums)) {
//         return 0;
//     }

//     $nums = array_diff($nums, array($val));
//     return count($nums);
// }

// 执行结果：通过
// 执行用时 : 4 ms, 在所有 php 提交中击败了96.24%的用户
// 内存消耗 : 14.7 MB, 在所有 php 提交中击败了41.60%的用户

// self(二) 
// function removeElement(&$nums, $val) 
// {
//     if (empty($nums)) {
//         return 0;
//     }

//     foreach ($nums as $key => $value) {
//         if ($val == $value) {
//             unset($nums[$key]);
//         }
//     }

//     return count($nums);
// }

// 算法思路：双指针：分为快慢指针
// 复杂度分析
// 时间复杂度：O(n)，假设数组的长度是 n，那么 i 和 j 分别最多遍历 n 步。
// 空间复杂度：O(1)。
// function removeElement(&$nums, $val) 
// {
//     $length = count($nums);
//     if ($length == 0) {
//         return 0;
//     }

//     $i = 0;
//     for ($j = 1; $j < $length; $j++) {
//         if ($nums[$j] != $val) {
//             $i++;
//             $nums[$i] = $nums[$j];
//         }
//     }

//     return $i + 1;
// }

// 双指针 —— 当要删除的元素很少时
// function removeElement(&$nums, $val)
// {
//     $i = 0;
//     $n = count($nums);
//     while ($i < $n) {
//         if ($nums[$i] == $val) {
//             $nums[$i] = $nums[$n - 1];
//             // reduce array size by one
//             $n--;
//         } else {
//             $i++;
//         }
//     }

//     return $n;
// }

// $nums = array(0,1,2,2,3,0,4,2);
// var_dump(removeElement($nums, 2));

#***************************************************************************************************************************
# 5. 搜索插入位置 (编号 #35)
// 给定一个排序数组和一个目标值，在数组中找到目标值，并返回其索引。如果目标值不存在于数组中，返回它将会被按顺序插入的位置。
// 你可以假设数组中无重复元素。

// 示例 1:
// 输入: [1,3,5,6], 5
// 输出: 2

// 示例 2:
// 输入: [1,3,5,6], 2
// 输出: 1

// 示例 3:
// 输入: [1,3,5,6], 7
// 输出: 4

// 示例 4:
// 输入: [1,3,5,6], 0
// 输出: 0

#***************************************************************************************************************************

// self(一) 
// function searchInsert($nums, $target)
// {
//     $index = array_search($target, $nums);
//     if ($index !== false) {
//         return $index;
//     }

//     $length = count($nums);
//     for ($i = 0; $i < $length; $i++) { 
//         if ($target <= $nums[$i]) {
//             return $i;
//         }
//     }

//     return $length;
// }

function searchInsert($nums, $target)
{
    $len = count($nums);
    if ($nums[$len - 1] < $target) {
        return $len;
    }

    $left = 0;
    $right = $len - 1;
    while ($left <= $right) {
        $mid = ($left + $right) / 2;
        // 等于的情况最简单，我们应该放在第 1 个分支进行判断
        if ($nums[$mid] == $target) {
            return $mid;
        } else if ($nums[$mid] < $target) {
            // 题目要我们返回大于或者等于目标值的第 1 个数的索引
            // 此时 $mid 一定不是所求的左边界，
            // 此时左边界更新为 $mid + 1
            $left = $mid + 1;
        } else {
            // 既然不会等于，此时 $nums[$mid] > $target
            // $mid 也一定不是所求的右边界
            // 此时右边界更新为 $mid - 1
            $right = $mid - 1;
        }
    }

    // 注意：一定得返回左边界 left，
    // 如果返回右边界 right 提交代码不会通过
    // 【注意】下面我尝试说明一下理由，如果你不太理解下面我说的，那是我表达的问题
    // 但我建议你不要纠结这个问题，因为我将要介绍的二分查找法模板，可以避免对返回 left 和 right 的讨论

    // 理由是对于 [1,3,5,6]，target = 2，返回大于等于 target 的第 1 个数的索引，此时应该返回 1
    // 在上面的 while (left <= right) 退出循环以后，right < left，right = 0 ，left = 1
    // 根据题意应该返回 left，
    // 如果题目要求你返回小于等于 target 的所有数里最大的那个索引值，应该返回 right

    return $left;
}

// var_dump(searchInsert(array(1,3,5,6), 7));

#***************************************************************************************************************************
# 6. 加一(编号 #66)
// 给定一个由整数组成的非空数组所表示的非负整数，在该数的基础上加一。
// 最高位数字存放在数组的首位， 数组中每个元素只存储单个数字。
// 你可以假设除了整数 0 之外，这个整数不会以零开头。

// 示例 1:
// 输入: [1,2,3]
// 输出: [1,2,4]
// 解释: 输入数组表示数字 123。

// 示例 2:
// 输入: [4,3,2,1]
// 输出: [4,3,2,2]
// 解释: 输入数组表示数字 4321。
#***************************************************************************************************************************

function plusOne($digits)
{
    $count = count($digits);
    $length = $count - 1;
    for ($i = $length; $i >= 0; $i--) {
        if ($digits[$i] == 9) {
            $digits[$i] = 0;
            $count--;
        } else {
            $digits[$i] += 1;
            return $digits;
        }
    }

    if ($count == 0) {
        array_unshift($digits, 1);
    }

    return $digits;
}

// function plusOne($digits)
// {
//     $count = count($digits);
//     $length = $count - 1;
//     for ($i = $length; $i >= 0; $i--) { 
//         ++$digits[$i];
//         $count--;
//         $digits[$i] = $digits[$i] % 10;
//         if ($digits[$i] != 0) {
//             return $digits;
//         }
//     }

//     if ($count == 0) {
//         array_unshift($digits, 1);
//     }

//     return $digits;
// }

// 执行结果：通过
// 执行用时 : 8 ms, 在所有 php 提交中击败了68.42%的用户
// 内存消耗 : 14.7 MB, 在所有 php 提交中击败了54.32%的用户

// var_dump(plusOne([4,9,9,9]));

#***************************************************************************************************************************
# 7. 合并两个有序数组 (编号 #88)
// 给定两个有序整数数组 nums1 和 nums2，将 nums2 合并到 nums1 中，使得 num1 成为一个有序数组。
// 说明:
// 初始化 nums1 和 nums2 的元素数量分别为 m 和 n。
// 你可以假设 nums1 有足够的空间（空间大小大于或等于 m + n）来保存 nums2 中的元素。

// 示例:

// 输入:
// nums1 = [1,2,3,0,0,0], m = 3
// nums2 = [2,5,6],       n = 3

// 输出: [1,2,2,3,5,6]
// 示例:
// 给定 nums = [2, 7, 11, 15], target = 9
// 因为 nums[0] + nums[1] = 2 + 7 = 9
// 所以返回 [0, 1]
#***************************************************************************************************************************

// 方法一
// 最朴素的解法就是将两个数组合并之后再排序。时间复杂度较差，为O((n+m)log(n+m))。
// 这是由于这种方法没有利用两个数组本身已经有序这一点。

// 复杂度分析
// 时间复杂度 : O((n+m)log(n+m))。
// 空间复杂度 : O(1)

// function merge(&$nums1, $m, $nums2, $n)
// {
//     $nums1 = array_slice($nums1, 0, $m);
//     $nums1 = array_merge($nums1, $nums2);
//     sort($nums1);
// }


// 方法二
// 一般而言，对于有序数组可以通过 双指针法 达到O(n + m)的时间复杂度。
// 最直接的算法实现是将指针p1 置为 nums1的开头， p2为 nums2的开头，在每一步将最小值放入输出数组中。
// 由于 nums1 是用于输出的数组，需要将nums1中的前m个元素放在其他地方，也就需要 O(m)的空间复杂度

// 复杂度分析
// 时间复杂度 : O(n + m)
// 空间复杂度 : O(m)

function merge(&$nums1, $m, $nums2, $n)
{
    $index1 = 0;
    $index2 = 0;
    $index3 = 0;

    $nums1Copy = array_slice($nums1, 0, $m);
    while ($index1 < $m && $index2 < $n) {
        $nums1[$index3++] = $nums1Copy[$index1] < $nums2[$index2] ? $nums1Copy[$index1++] : $nums2[$index2++];
    }

    if ($index1 < $m) {
        $nums1 = array_slice($nums1, 0, $index1 + $index2);
        $nums1 = array_merge($nums1, array_slice($nums1Copy, $index1, $m - $index1));
    }

    if ($index2 < $n) {
        $nums1 = array_slice($nums1, 0, $index1 + $index2);
        $nums1 = array_merge($nums1, array_slice($nums2, $index2, $n - $index2));
    }
}


// 方法三
// 方法二已经取得了最优的时间复杂度O(n + m)，但需要使用额外空间。这是由于在从头改变nums1的值时，
// 需要把nums1中的元素存放在其他位置。如果我们从结尾开始改写 nums1 的值又会如何呢？这里没有信息，因此不需要额外空间。
// 这里的指针 p 用于追踪添加元素的位置。

// 复杂度分析
// 时间复杂度 : O(n + m)
// 空间复杂度 : O(1)

// function merge(&$nums1, $m, $nums2, $n)
// {
//     $index1 = $m - 1;
//     $index2 = $n - 1;
//     $index3 = $m + $n - 1;

//     while ($index1 >= 0 && $index2 >= 0) {
//         $nums1[$index3--] = $nums1[$index1] < $nums2[$index2] ? $nums2[$index2--] : $nums1[$index1--];
//     }

//     sort($nums1);
// }

// $nums1 = array(1,2,3,0,0,0);
// $nums2 = array(2,5,6);
// merge($nums1, 3, $nums2, 3);
// var_dump($nums1);

#***************************************************************************************************************************
# 8. 杨辉三角（动态规划） (编号 #118)
// 给定一个非负整数 numRows，生成杨辉三角的前 numRows 行。
// 在杨辉三角中，每个数是它左上方和右上方的数的和。

// 输入: 5
// 输出:
// [
//      [1],
//     [1,1],
//    [1,2,1],
//   [1,3,3,1],
//  [1,4,6,4,1]
// ]

// [
//      [1],
//     [1,1],
//    [1,2,1],
//   [1,3,3,1],
//  [1,4,6,4,1]
// ]
#***************************************************************************************************************************

// 思路一：使用两层循环
// 0、外层循环决定有多少层。
// 1、内层循环决定没层的数据。
// 算法：
// 0、从0开始遍历每一层。
// 1、遍历当前层的时候，把当前层的数据存在临时变量tmp中，初始化为只有一个元素1的数组。 2、遍历当前层上层的元素，
// 每次把上层相邻的元素加和，追加到tmp中，初始化为只有一个元素1的数组。2、遍历当前层上层的元素，每次把上层相邻的元素加和，追加到tmp中。
// 3、当前层上层的元素遍历完成后，当前层的数据就生成完成，放到终止结果中。

// 复杂度分析
// 因为外层每次迭代的过程中,内层都要循环n次,即1+2+3+4+5+...,所以根据高斯公式 n(n+1)/2可得
// 时间复杂度：O(n^2)
function generate($numRows)
{
    $triangle = [];
    for ($i = 0; $i < $numRows; $i++) {
        $tmp = [1];
        for ($j = 0; $j < $i; $j++) {
            // 当$j = $i - 1的时候，已经说明已经是最后一个元素了，单独处理
            // 理论上$j == $i - 1的概率比较小，放到else效率应该更高，实际测试没有区别
            if ($j == $i - 1) {
                $tmp[] = $triangle[$i - 1][$j];
            } else {
                $tmp[] = $triangle[$i - 1][$j] + $triangle[$i - 1][$j + 1];
            }
        }

        $triangle[] = $tmp;
    }

    return $triangle;
}

// 解题思路二
// 思路二、动态规划

// 算法：
// 0、状态:
// dp[0] = [1];dp[1] = [1,1];
// 1、状态转移方程：
// dp[i][] = dp[i-1][j-1]+dp[i-1][j];

// function generate($numRows)
// {
//     if ($numRows == 0) {
//         return [];
//     }

//     if ($numRows == 1) {
//         return [[1]];
//     }

//     $dp[0] = [1];
//     $dp[1] = [1,1];
//     for($i = 2; $i < $numRows; $i++) {
//         $dp[$i][] = 1;
//         for($j = 1; $j < $i; $j++) {
//             $dp[$i][] = $dp[$i-1][$j-1]+$dp[$i-1][$j];
//         }
//         $dp[$i][] = 1;
//     }

//     return $dp;
// }

#***************************************************************************************************************************
# 9. 杨辉三角 II (编号 #119)
// 给定一个非负索引 k，其中 k ≤ 33，返回杨辉三角的第 k 行。
// 在杨辉三角中，每个数是它左上方和右上方的数的和。

// 输入: 5
// 输出:
// [
//      [1],
//     [1,1],
//    [1,2,1],
//   [1,3,3,1],
//  [1,4,6,4,1]
// ]

// 进阶：
// 你可以优化你的算法到 O(k) 空间复杂度吗？  //TODO 未实现 没有思路
#***************************************************************************************************************************

function getRow($rowIndex)
{
    $rowIndex += 1;
    $triangle = array();
    for ($i = 0; $i < $rowIndex; $i++) {
        $temp[$i][0] = 1;
        for ($j = 0; $j < $i; $j++) {
            if ($j == $i - 1) {
                $temp[$i][] = $triangle[$i - 1][$j];
            } else {
                $temp[$i][] = $triangle[$i - 1][$j] + $triangle[$i - 1][$j + 1];
            }
        }

        $triangle = $temp;
        $temp = [];
    }

    return $triangle[$rowIndex - 1];
}

// var_dump(getRow(5));

#***************************************************************************************************************************
# 10. 买卖股票的最佳时机 (编号 #121)
// 给定一个数组，它的第 i 个元素是一支给定股票第 i 天的价格。
// 如果你最多只允许完成一笔交易（即买入和卖出一支股票），设计一个算法来计算你所能获取的最大利润。

// 注意你不能在买入股票前卖出股票。

// 示例 1:
// 输入: [7,1,5,3,6,4]
// 输出: 5
// 解释: 在第 2 天（股票价格 = 1）的时候买入，在第 5 天（股票价格 = 6）的时候卖出，最大利润 = 6-1 = 5 。
//      注意利润不能是 7-1 = 6, 因为卖出价格需要大于买入价格。

// 示例 2:
// 输入: [7,6,4,3,1]
// 输出: 0
// 解释: 在这种情况下, 没有交易完成, 所以最大利润为 0。
#***************************************************************************************************************************

// 我们需要找出给定数组中两个数字之间的最大差值（即，最大利润）。此外，第二个数字（卖出价格）必须大于第一个数字（买入价格）。
// 形式上，对于每组 i 和 j（其中 j > i）我们需要找出 max(prices[j] - prices[i])。

// 方法一
// 暴力破解 运行超出时间显示
// 时间复杂度：O(n^2)；循环n(n - 1) / 2次
// 空间复杂度：O(1)
// function maxProfit($prices)
// {
//     $maxprofit = 0;
//     $length = count($prices);
//     for ($i = 0; $i < $length; $i++) {
//         for ($j = $i + 1; $j < $length; $j++) {
//             $profit = $prices[$j] - $prices[$i];
//             if ($profit > $maxprofit) {
//                 $maxprofit = $profit;
//             }
//         }
//     }
//     return $maxprofit;
// }

// 方法二
// 把数组中的数字画到纸上然后用直线连起来就会发现有波峰和波谷，然后我们只需要找到最小的谷之后的最大的峰。
// 我们可以维持两个变量——minprice 和 maxprofit，它们分别对应迄今为止所得到的最小的谷值和最大的利润（卖出价格与最低价格之间的最大差值）。

// 复杂度分析
// 时间复杂度：O(n)，只需要遍历一次。
// 空间复杂度：O(1)，只使用了两个变量。
function maxProfit($prices)
{
    $maxprofit = 0;
    $minprice = $prices[0]; // 默认第一个数组的值最小
    $length = count($prices);
    for ($i = 0; $i < $length; $i++) {
        if ($prices[$i] < $minprice) {
            $minprice = $prices[$i];
        } else if ($prices[$i] - $minprice > $maxprofit) {
            $maxprofit = $prices[$i] - $minprice;
        }
    }
    return $maxprofit;
}

// $prices = [7,1,5,3,6,4];
// var_dump(maxProfit($prices));


#***************************************************************************************************************************
# 11. 买卖股票的最佳时机 II (编号 #122)
// 给定一个数组，它的第 i 个元素是一支给定股票第 i 天的价格。
// 设计一个算法来计算你所能获取的最大利润。你可以尽可能地完成更多的交易（多次买卖一支股票）。

// 注意：你不能同时参与多笔交易（你必须在再次购买前出售掉之前的股票）。

// 示例 1:
// 输入: [7,1,5,3,6,4]
// 输出: 7
// 解释: 在第 2 天（股票价格 = 1）的时候买入，在第 3 天（股票价格 = 5）的时候卖出, 这笔交易所能获得利润 = 5-1 = 4 。
//      随后，在第 4 天（股票价格 = 3）的时候买入，在第 5 天（股票价格 = 6）的时候卖出, 这笔交易所能获得利润 = 6-3 = 3 。

// 示例 2:
// 输入: [1,2,3,4,5]
// 输出: 4
// 解释: 在第 1 天（股票价格 = 1）的时候买入，在第 5 天 （股票价格 = 5）的时候卖出, 这笔交易所能获得利润 = 5-1 = 4 。
//      注意你不能在第 1 天和第 2 天接连购买股票，之后再将它们卖出。
//      因为这样属于同时参与了多笔交易，你必须在再次购买前出售掉之前的股票。

// 示例 3:
// 输入: [7,6,4,3,1]
// 输出: 0
// 解释: 在这种情况下, 没有交易完成, 所以最大利润为 0。

#***************************************************************************************************************************

// 我们必须确定通过交易能够获得的最大利润（对于交易次数没有限制）。为此，我们需要找出那些共同使得利润最大化的买入及卖出价格。

// 解决方案
// 方法一：暴力法
// 这种情况下，我们只需要计算与所有可能的交易组合相对应的利润，并找出它们中的最大利润。

// self 方法一
function maxProfit2($prices)
{
    $maxprofit = 0;
    $sumprofit = 0;
    $minprice = $prices[0]; // 默认第一个为最小值
    $count = count($prices);
    for ($i = 0; $i < $count; $i++) {
        if ($prices[$i] < $minprice) {
            $minprice = $prices[$i];  // 找出阶段最小值
        } else if ($prices[$i] - $minprice > $maxprofit) { // 利润为正且为最大的时候累加，并重置最大利润为0，设置当前数值后面的值为最小值
            $maxprofit = $prices[$i] - $minprice;

            if ($prices[$i] >= $prices[$i + 1]) {
                $sumprofit += $maxprofit;
                $minprice = $prices[$i + 1];
                $maxprofit = 0;
            }
        }
    }

    return $sumprofit;
}

// 方法二
// function maxProfit2($prices)
// {
//     $maxprofit = 0;
//     for ($i = 1; $i < count($prices); $i++)
//         if ($prices[$i] > $prices[$i - 1]) {
//             $maxprofit += $prices[$i] - $prices[$i - 1];
//         }

//     return $maxprofit;
// }

$prices = [5, 2, 3, 2, 6, 6, 2, 9, 1, 0, 7, 4, 5, 0];
// var_dump(maxProfit2($prices));
