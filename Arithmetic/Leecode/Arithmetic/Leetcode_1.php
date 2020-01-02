<?php

#***************************************************************************************************************************
# 1. 给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那两个整数，并返回他们的数组下标。
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

// 解法二 self 时间复杂度降为O(n) 
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

// var_dump(twoSum(array(3, 2, 4), 6));


#***************************************************************************************************************************
# 2. 删去字符串中的元音
// 示例:
// 输入："leetcodeisacommunityforcoders"
// 输出："ltcdscmmntyfrcdrs"
#***************************************************************************************************************************

// $initString = 'leetcodeisacommunityforcoders';
// $endString = str_replace(array('a', 'e', 'i', 'o', 'u'), '', $initString);
// var_dump($endString);

#***************************************************************************************************************************
# 3. 猜数字   
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
# 3. 宝石与石头
// 给定字符串J 代表石头中宝石的类型，和字符串 S代表你拥有的石头。 S 中每个字符代表了一种你拥有的石头的类型，你想知道你拥有的石头中有多少是宝石。
// J 中的字母不重复，J 和 S中的所有字符都是字母。字母区分大小写，因此"a"和"A"是不同类型的石头。

// 示例 1:
// 输入: J = "aA", S = "aAAbbbb"
// 输出: 3
// 示例 2:

// 示例 2:
// 输入: J = "z", S = "ZZ"
// 输出: 0
// 注意:

// 提示：
// S 和 J 最多含有50个字母。
// J 中的字符不重复。
#***************************************************************************************************************************

// 方法一(self)
// function numJewelsInStones($J, $S) {
//     $JArray = str_split($J);
//     $SArray = str_split($S);
//     return count(array_intersect($SArray, $JArray));
// }
// 执行结果：通过
// 执行用时 : 4 ms, 在所有 php 提交中击败了 97.71% 的用户
// 内存消耗 : 15.1 MB, 在所有 php 提交中击败了 5.51% 的用户

// 方法二
// function numJewelsInStones($J, $S) {
//     return count(array_intersect(str_split($S), str_split($J)));
// }
// 有时代码行数少了不见得效率就高
// 执行结果：通过
// 执行用时 : 12 ms, 在所有 php 提交中击败了 27.43% 的用户
// 内存消耗 : 15 MB, 在所有 php 提交中击败了 5.51% 的用户

// 方法三
// function numJewelsInStones($J, $S) {
//     return strlen($S) - strlen(str_replace(str_split($J), '', $S));
// }
// 执行结果：通过
// 执行用时 : 8 ms, 在所有 php 提交中击败了 71.43% 的用户
// 内存消耗 : 14.8 MB, 在所有 php 提交中击败了 19.27% 的用户

// 方法四
// function numJewelsInStones($J, $S)
// {
//     $countJ = strlen($J);
//     if ($countJ == 0) {
//         return 0;
//     }
    
//     $out = 0;
//     $hash = [];
//     $countS = strlen($S);
//     for ($i = 0; $i < $countJ; $i++) {
//         $hash[$J[$i]] = 1;
//     }

//     for ($i = 0; $i < $countS; $i++) {
//         if (isset($hash[$S[$i]])) {
//             $out++;
//         }
//     }
//     return $out;
// }
// 执行结果：通过
// 执行用时 : 12 ms, 在所有 php 提交中击败了 27.43% 的用户
// 内存消耗 : 15 MB, 在所有 php 提交中击败了 5.51% 的用户

// 方法五
// function numJewelsInStones($J, $S)
// {
//     $bao = str_split($J);
//     $i = 0;
//     foreach ($bao as $v) {
//         $i += substr_count($S, $v);
//     }
//     return $i;
// }
// 执行结果：通过
// 执行用时 : 8 ms, 在所有 php 提交中击败了 71.43% 的用户
// 内存消耗 : 14.8 MB, 在所有 php 提交中击败了 26.61% 的用户


#***************************************************************************************************************************
# 4. 单行键盘
// 我们定制了一款特殊的力扣键盘，所有的键都排列在一行上。
// 我们可以按从左到右的顺序，用一个长度为 26 的字符串 keyboard （索引从 0 开始，到 25 结束）来表示该键盘的键位布局。
// 现在需要测试这个键盘是否能够有效工作，那么我们就需要个机械手来测试这个键盘。
// 最初的时候，机械手位于左边起第一个键（也就是索引为 0 的键）的上方。当机械手移动到某一字符所在的键位时，就会在终端上输出该字符。
// 机械手从索引 i 移动到索引 j 所需要的时间是 |i - j|。
// 当前测试需要你使用机械手输出指定的单词 word，请你编写一个函数来计算机械手输出该单词所需的时间。

// 示例 1:
// 输入：keyboard = "abcdefghijklmnopqrstuvwxyz", word = "cba"
// 输出：4
// 解释：
// 机械手从 0 号键移动到 2 号键来输出 'c'，又移动到 1 号键来输出 'b'，接着移动到 0 号键来输出 'a'。
// 总用时 = 2 + 1 + 1 = 4. 

// 示例 2:
// 输入：keyboard = "pqrstuvwxyzabcdefghijklmno", word = "leetcode"
// 输出：73

// 提示：
// keyboard.length == 26
// keyboard 按某种特定顺序排列，并包含每个小写英文字母一次。
// 1 <= word.length <= 10^4
// word[i] 是一个小写英文字母
#***************************************************************************************************************************
// function calculateTime($keyboard, $word)
// {
//     $time = 0;
//     $lastIndex = 0;
//     $wordLength = strlen($word);
//     for ($i = 0; $i < $wordLength; $i++) {
//         $currentIndex = strpos($keyboard, $word[$i]);
//         if ($currentIndex !== false) {
//             $time += abs($lastIndex - $currentIndex);
//             $lastIndex = $currentIndex;
//         }
//     }

//     return $time;
// }

// var_dump(calculateTime("pqrstuvwxyzabcdefghijklmno", "leetcode"));

#***************************************************************************************************************************
# 5. 整数的各位积和之差
// 给你一个整数 n，请你帮忙计算并返回该整数「各位数字之积」与「各位数字之和」的差。

// 示例 1：
// 输入：n = 234
// 输出：15 
// 解释：
// 各位数之积 = 2 * 3 * 4 = 24 
// 各位数之和 = 2 + 3 + 4 = 9 
// 结果 = 24 - 9 = 15

// 示例 2：
// 输入：n = 4421
// 输出：21
// 解释： 
// 各位数之积 = 4 * 4 * 2 * 1 = 32 
// 各位数之和 = 4 + 4 + 2 + 1 = 11 
// 结果 = 32 - 11 = 21

// 提示：
// 1 <= n <= 10^5
#***************************************************************************************************************************
// self
function subtractProductAndSum($n)
{
    $n = str_split(strval($n));
    return intval(array_product($n) - array_sum($n));
}

// var_dump(subtractProductAndSum(4421));

// 执行结果：通过
// 执行用时 : 4 ms, 在所有 php 提交中击败了100.00%的用户
// 内存消耗 : 15.1 MB, 在所有 php 提交中击败了100.00%的用户

#***************************************************************************************************************************
# 6. 给你一个有效的 IPv4 地址 address，返回这个 IP 地址的无效化版本。
// 所谓无效化 IP 地址，其实就是用 "[.]" 代替了每个 "."。

// 示例 1：
// 输入：address = "1.1.1.1"
// 输出："1[.]1[.]1[.]1"

// 示例 2：
// 输入：address = "255.100.50.0"
// 输出："255[.]100[.]50[.]0"

// 提示：
// 给出的 address 是一个有效的 IPv4 地址
#***************************************************************************************************************************

// function defangIPaddr($address)
// {
//     return str_replace('.', '[.]', $address);
// }

// 执行结果：通过
// 执行用时 : 8 ms, 在所有 php 提交中击败了59.15%的用户
// 内存消耗 : 15 MB, 在所有 php 提交中击败了100.00%的用户


// function defangIPaddr($address)
// {
//     return implode('[.]', explode('.', $address));
// }

// 执行结果：通过
// 执行用时 : 8 ms, 在所有 php 提交中击败了59.15%的用户
// 内存消耗 : 15.1 MB, 在所有 php 提交中击败了100.00%的用户

// var_dump(defangIPaddr('265.0.1.2'));

#***************************************************************************************************************************
# 7. 删除排序数组中的重复项
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
# 8. 移除元素
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
# 9. 搜索插入位置
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
# 10. 加一
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

var_dump(plusOne([4,9,9,9]));