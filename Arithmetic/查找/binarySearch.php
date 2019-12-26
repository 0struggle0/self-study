<?php

/*
 * @Description: 二分查找
 * @Date: 2019-12-26 21:41:53
 * @LastEditTime : 2019-12-26 21:42:32
 */
function searchInsert($nums, $target)
{
    $left = 0;
    $right = count($nums) - 1;
    while ($left <= $right) {
        $mid = intval(($left + $right) / 2);
        if ($nums[$mid] == $target) {
            return $mid;
        } else if ($nums[$mid] < $target) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }

    return false;
}

var_dump(searchInsert(array(1,3,5,6), 6));