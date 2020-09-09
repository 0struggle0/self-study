<?php

#***************************************************************************************************************************
// 11. 旋转数组的最小数字
// 把一个数组最开始的若干个元素搬到数组的末尾，我们称之为数组的旋转。
// 输入一个递增排序的数组的一个旋转，输出旋转数组的最小元素。
// 例如，数组 [3,4,5,1,2] 为 [1,2,3,4,5] 的一个旋转，该数组的最小值为1。  

// 示例 1：
// 输入：[3,4,5,1,2]
// 输出：1

// 示例 2：
// 输入：[2,2,2,0,1]
// 输出：0
#***************************************************************************************************************************

// 有问题，待改进的答案
function minArray($numbers) 
{
    // 如果参数数组为空或者参数不是数组类型，则直接返回
    if (empty($numbers) || !is_array($numbers)) {
        return false;
    }
    
    // 如果参数数组只有一个值，直接返回该值
    $firstValue = $numbers[0];
    $numbersLength = count($numbers);
    if ($numbersLength == 1) {
        return $firstValue;
    }

    // 如果参数数组没有旋转，则直接返回第一个值
    // 为什么要等于，因为数组可能是一组相同的值组成
    $endValue = end($numbers);
    if ($firstValue <= $endValue) {
        return $firstValue;
    }

    for ($index = $numbersLength - 1; $index >= 0; $index--) { 
        if ($numbers[$index] >= $firstValue) {
            return $numbers[$index + 1];
        }
    }
}

// var_dump(minArray([3,1,3]));