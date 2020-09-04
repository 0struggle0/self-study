<?php

/*
 * @Description: 
 * @Date: 2020-08-26 17:13:17
 * @LastEditTime: 2020-09-04 10:31:47
 */

#***************************************************************************************************************************
// 01. 
#***************************************************************************************************************************


#***************************************************************************************************************************
// 02. 
#***************************************************************************************************************************


#***************************************************************************************************************************
// 03. 数组中重复的数字
// 在一个长度为 n 的数组 nums 里的所有数字都在 0～n-1 的范围内。
// 数组中某些数字是重复的，但不知道有几个数字重复了，也不知道每个数字重复了几次。
// 请找出数组中任意一个重复的数字。找出数组中重复的数字。

// 示例 1：
// 输入：[2, 3, 1, 0, 2, 5, 3]
// 输出：2 或 3 

// 限制：
// 2 <= n <= 100000
#***************************************************************************************************************************

// 方法一：利用内置方法统计数组中数字出现的次数，然后遍历寻找重复的数字输出
// function findRepeatNumber($nums) 
// {
//     if (empty($nums) || !is_array($nums)) {
//         return false;
//     }

//     $memberCount = array_count_values($nums);

//     // 找出单个重复的数字
//     foreach ($memberCount as $number => $numberCount) {
//         if ($numberCount > 1) {
//             return $number;
//         }
//     }

//     // // 找出所有重复的数字
//     // $result = [];
//     // foreach ($memberCount as $number => $numberCount) {
//     //     if ($numberCount > 1) {
//     //         $result[] = $number;
//     //     }
//     // }
//     // return $result;
// }

// 方法二：利用hash，做一个键值映射，把数字作为键，出现的次数作为值，先遍历参数数组生成hash数组，然后遍历hash数组找重复的数字
// function findRepeatNumber($nums) 
// {
//     if (empty($nums) || !is_array($nums)) {
//         return false;
//     }

//     // 找出单个重复的数字
//     $temp = [];
//     foreach ($nums as $number) {
//         if (isset($temp[$number])) {
//             return $number;
//         }
//         $temp[$number] = 1;
//     }

//     // 没有重复的数字时返回false
//     return false;

//     // 找出所有重复的数字
//     // $numberCounts = [];
//     // foreach ($nums as $number) {
//     //     if (isset($temp[$number])) {
//     //         $temp[$number]++;
//     //     } else {
//     //         $temp[$number] = 1;
//     //     }
//     // }

//     // $result = [];
//     // foreach ($numberCounts as $newNumber => $numberCount) {
//     //     if ($numberCount > 1) {
//     //         $result[] = $newNumber;
//     //     }
//     // }

//     // return $result;
// }

// 方法三：《剑指offer》书中的思路
// 先对参数数组升序排序，如果没有重复数字，那么排序后数字i应该在下标为i的位置。
// 所以从头遍历参数数组，遇到下标为i的数字如果不是i的话，（假设为m), 那么我们就拿与下标m的数字交换。
// 在交换过程中，如果发现某一个下标已经与它对应的值相等了，但是还有数字想与之交换，那么终止返回该数字
function findRepeatNumber($nums) 
{
    if (empty($nums) || !is_array($nums)) {
        return false;
    }

    sort($nums);
    foreach ($nums as $index => $number) {
        if ($index == $number) {
            continue;
        } 

        if ($nums[$number] != $number) {
            $temp = $nums[$number];
            $nums[$number] = $number;
            $nums[$index] = $temp;
        } else {
            return $number;
        }
    }
}

// var_dump(findRepeatNumber([2, 3, 1, 0, 2, 5, 3]));

#***************************************************************************************************************************
// 04. 二维数组中的查找
// 在一个 n * m 的二维数组中，每一行都按照从左到右递增的顺序排序，每一列都按照从上到下递增的顺序排序。
// 请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。
// 示例 ：
// 现有矩阵 matrix 如下：
// [
//     [1,   4,  7, 11, 15],
//     [2,   5,  8, 12, 19],
//     [3,   6,  9, 16, 22],
//     [10, 13, 14, 17, 24],
//     [18, 21, 23, 26, 30]
// ]

// 给定 target = 5，返回 true。
// 给定 target = 20，返回 false。

// 限制：
// 0 <= n <= 1000
// 0 <= m <= 1000
#***************************************************************************************************************************

// // 方法一：简单粗暴
// // 复杂度分析:
// // 时间复杂度：O(nm)。二维数组中的每个元素都被遍历，因此时间复杂度为二维数组的大小。
// // 空间复杂度：O(1)。
// function findNumberIn2DArray($matrix, $target) 
// {
//     if (empty($matrix) || !is_array($matrix) || empty($target)) {
//         return false;
//     }

//     foreach ($matrix as $value) {
//         if (in_array($target, $value)) {
//             return true;
//         }
//     }
//     return false;
// }

// 方法二：《剑指offer》书中的思路
// 从右上角开始走
// 如果相等，返回true
// 如果当前位置元素比target大，则col--
// 如果当前位置元素比target小，则row++
// 如果越界了还没找到，说明不存在，返回false
// 复杂度分析:
// 时间复杂度：O(n+m)。访问到的下标的行最多增加 n 次，列最多减少 m 次，因此循环体最多执行 n + m 次。
// 空间复杂度：O(1)。
function findNumberIn2DArray($matrix, $target) 
{
    if (empty($matrix) || !is_array($matrix) || empty($target)) {
        return false;
    }

    $row = 0;
    $col = count($matrix[0]) - 1;
    while (isset($matrix[$row][$col])) {
        if ($target == $matrix[$row][$col]) {
            return true;
        } else if ($target < $matrix[$row][$col]) {
            $col--;
        } else {
            $row++;
        }
    }
    return false;
}

// $matrix = 
//     [
//         [1,   4,  7, 11, 15],
//         [2,   5,  8, 12, 19],
//         [3,   6,  9, 16, 22],
//         [10, 13, 14, 17, 24],
//         [18, 21, 23, 26, 30]
//     ];
    
// $target = 5;
// var_dump(findNumberIn2DArray($matrix, $target));

#***************************************************************************************************************************
// 05.
#***************************************************************************************************************************


#***************************************************************************************************************************
// 06. 从尾到头打印链表
// 输入一个链表的头节点，从尾到头反过来返回每个节点的值（用数组返回）。

// 示例 1：
// 输入：head = [1,3,2]
// 输出：[2,3,1]
 
// 限制：
// 0 <= 链表长度 <= 10000
#***************************************************************************************************************************

// 方法一 
// 利用栈的特点
// 栈的特点是先进后出，即最后压入栈的元素最先弹出。
// 考虑到栈的这一特点，使用栈将链表元素顺序倒置。
// 从链表的头节点开始，依次将每个节点压入栈内，然后依次弹出栈内的元素并存储到数组中。
// 复杂性分析：
// 时间复杂度：O(n)。正向遍历一遍链表，然后从栈弹出全部节点，等于又反向遍历一遍链表。
// 空间复杂度：O(n)。额外使用一个栈存储链表中的每个节点。
function reversePrint($head) 
{
    // 这里不用辅助数据结构栈也可以，可以用数组类型，毕竟PHP数组比较灵活，既可以当栈，又可以当队列等使用
    $stack = new SplStack();
    while ($head) {
        $stack->push($head->val);
        $head = $head->next;
    }

    $result = [];
    while (!$stack->isEmpty()) {
        $result[] = $stack->pop();
    }

    return $result;
}

// var_dump(reversePrint([1,3,2]));

#***************************************************************************************************************************
// 09. 用两个栈实现队列
// 用两个栈实现一个队列。
// 队列的声明如下，请实现它的两个函数 appendTail 和 deleteHead ，
// 分别完成在队列尾部插入整数和在队列头部删除整数的功能。(若队列中没有元素，deleteHead 操作返回 -1 )


// 示例 1：
// 输入：
// ["CQueue","appendTail","deleteHead","deleteHead"]
// [[],[3],[],[]]
// 输出：[null,null,3,-1]

// 示例 2：
// 输入：
// ["CQueue","deleteHead","appendTail","appendTail","deleteHead","deleteHead"]
// [[],[],[5],[2],[],[]]
// 输出：[null,-1,null,null,5,2]

// 提示：
// 1 <= values <= 10000
// 最多会对 appendTail、deleteHead 进行 10000 次调用
#***************************************************************************************************************************

class CQueue {
    private $stackOne; // 入队
    private $stackTwo; // 出队

    /**
     */
    function __construct() {
        $this->stackOne = new SplStack();
        $this->stackTwo = new SplStack();
    }

    /**
     * @param Integer $value
     * @return NULL
     */
    function appendTail($value) {
        $this->stackOne->push($value);
    }

    /**
     * @return Integer
     */
    function deleteHead() {
        if ($this->stackTwo->isEmpty()) {
            while (!$this->stackOne->isEmpty()) {
                $this->stackTwo->push($this->stackOne->pop());
            }
            
            if (!$this->stackTwo->isEmpty()) {
                return $this->stackTwo->pop();
            } else {
                return -1;
            }
        } else {
            return $this->stackTwo->pop();
        }
    }
}