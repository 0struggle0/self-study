<?php

#***************************************************************************************************************************
# 第一给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标。
// 你可以假设每种输入只会对应一个答案。但是，你不能重复利用这个数组中同样的元素。
// 示例:
// 给定 nums = [2, 7, 11, 15], target = 9
// 因为 nums[0] + nums[1] = 2 + 7 = 9
// 所以返回 [0, 1]
#***************************************************************************************************************************

// 解法一 self (暴力破解)  时间复杂度O(n^2)  空间复杂度O(1)
// function twoSum($nums, $target) {
//     foreach ($nums as $key => $num) {
//         foreach ($nums as $keyBak => $numBak) {
//             if ($key != $keyBak && ($num + $numBak == $target)) {
//                 return array($key, $keyBak);
//             }
//         }
//     }
// }

// 解法二
// function twoSum($nums, $target) {
//     $find = [];
//     $count = count($nums);

//     for ($i = 0; $i < $count; $i++) {
//         $value = $nums[$i];
        
//         if ($a = array_keys($find, ($target - $value))) {
//             return [$a[0], $i];
//         }
        
//         $find[$i] = $value;
//     }
// }

var_dump(twoSum(array(3, 2, 4), 6));