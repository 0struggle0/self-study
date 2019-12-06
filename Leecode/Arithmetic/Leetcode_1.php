<?php

#***************************************************************************************************************************
# 1. 给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标。
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

// 方法二
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
function calculateTime($keyboard, $word)
{
    $Index = 0;
    $lastIndex = 0;
    $wordLength = strlen($word);
    for ($i = 0; $i < $wordLength; $i++) {
        $currentIndex = strpos($keyboard, $word[$i]);
        if ($currentIndex !== false) {
            $Index += abs($lastIndex - $currentIndex);
            $lastIndex = $currentIndex;
        }
    }

    return $Index;
}

var_dump(calculateTime("pqrstuvwxyzabcdefghijklmno", "leetcode"));