<?php

#***************************************************************************************************************************
# 1. 罗马数字转整数 (编号 #13)
// 罗马数字包含以下七种字符: I， V， X， L，C，D 和 M。
// 字符          数值
// I             1
// V             5
// X             10
// L             50
// C             100
// D             500
// M             1000
// 例如， 罗马数字 2 写做 II ，即为两个并列的 1。12 写做 XII ，即为 X + II 。 27 写做  XXVII, 即为 XX + V + II 。
// 通常情况下，罗马数字中小的数字在大的数字的右边。但也存在特例，例如 4 不写做 IIII，而是 IV。数字 1 在数字 5 的左边，
// 所表示的数等于大数 5 减小数 1 得到的数值 4 。同样地，数字 9 表示为 IX。这个特殊的规则只适用于以下六种情况：

// I 可以放在 V (5) 和 X (10) 的左边，来表示 4 和 9。
// X 可以放在 L (50) 和 C (100) 的左边，来表示 40 和 90。 
// C 可以放在 D (500) 和 M (1000) 的左边，来表示 400 和 900。
// 给定一个罗马数字，将其转换成整数。输入确保在 1 到 3999 的范围内。

// 示例 1:
// 输入: "III"
// 输出: 3

// 示例 2:
// 输入: "IV"
// 输出: 4

// 示例 3:
// 输入: "IX"
// 输出: 9

// 示例 4:
// 输入: "LVIII"
// 输出: 58
// 解释: L = 50, V= 5, III = 3.

// 示例 5:
// 输入: "MCMXCIV"
// 输出: 1994
// 解释: M = 1000, CM = 900, XC = 90, IV = 4.
#***************************************************************************************************************************

// 方法一
function romanToInt($s)
{
    $result = 0;
    $strlength = strlen($s);
    $array = ['I' => 1, 'V' => 5, 'X' => 10, 'L' => 50, 'C' => 100, 'D' => 500, 'M' => 1000];
    for ($i = 0; $i < $strlength; $i++) {
        // 如果当前字符是字符串最后一个字符或者当前字符大于后一个字符时，直接加上当前字符的值；否则代表两个连续的字符的值
        if ($i + 1 >= $strlength || $array[$s[$i]] >= $array[$s[$i + 1]]) {
            $result += $array[$s[$i]];
        } else {
            $result += $array[$s[$i + 1]] - $array[$s[$i]];
            $i = $i + 1;
        }
    }
    return $result;
}

// 方法二： 遍历+双指针+哈希表映射
// function romanToInt($s)
// {
//     $num = 0;
//     $count = strlen($s);
//     $array = ['I' => 1, 'V' => 5, 'X' => 10, 'L' => 50, 'C' => 100, 'D' => 500, 'M' => 1000];
//     for ($i = 0; $i < $count; $i++) {
//         $next = $i + 1;
//         $num = $array[$s[$next]] > $array[$s[$i]] ? $num - $array[$s[$i]] : $num + $array[$s[$i]];
//     }
//     return $num;
// }

// 方法三：暴力破解，不如方法一、二巧妙
// function romanToInt($s)
// {
//     $gz = [
//         'I' => 1, 'V' => 5, 'X' => 10, 'L' => 50, 'C' => 100, 'D' => 500, 'M' => 1000,
//         'IV' => 4, 'IX' => 9, 'XL' => 40, 'XC' => 90, 'CD' => 400, 'CM' => 900,
//     ];

//     $num = 0;
//     $begin = 0;
//     while ($begin < strlen($s)) {
//         $tow_bit = substr($s, $begin, 2);
//         if (array_key_exists($tow_bit, $gz)) {
//             $num += $gz[$tow_bit];
//             $begin += 2;
//         } else {
//             $one_bit = substr($s, $begin, 1);
//             if (array_key_exists($one_bit, $gz)) {
//                 $num += $gz[$one_bit];
//                 $begin += 1;
//             }
//         }
//     }
//     return $num;
// }

#***************************************************************************************************************************
# 2. 最长公共前缀 (编号 #14)
// 编写一个函数来查找字符串数组中的最长公共前缀。
// 如果不存在公共前缀，返回空字符串 ""。

// 示例 1:
// 输入: ["flower","flow","flight"]
// 输出: "fl"

// 示例 2:
// 输入: ["dog","racecar","car"]
// 输出: ""

// 解释: 输入不存在公共前缀。

// 说明:
// 所有输入只包含小写字母 a-z 。
#***************************************************************************************************************************

// 方法一
function longestCommonPrefix($strs)
{
    $res = '';
    $count = count($strs);
    $minStr = findMinLenStr($strs, $count); //或者可以直接默认数组中第一个值就是最小的
    $count = count($strs);
    $minlen = strlen($minStr);

    // 用最小值每个字符去剩下的数组中每个值循环判断
    for ($j = 0; $j < $minlen; $j++) { // 循环最下字符串
        for ($k = 0; $k < $count; $k++) { // 循环数组
            if ($minStr[$j] != $strs[$k][$j]) {  // 判断值是否相等
                return $res;
            }
        }

        $res .= $minStr[$j]; // 追加到结果集中
    }

    return $res;
}

function findMinLenStr(&$strs, $length)
{
    $minx = 0;
    $minStr = $strs[$minx]; // 默认第一个值为最小
    $minlen = strlen($minStr); // 最小值长度
    // 找出最小长度的字符串键
    for ($i = 1; $i < $length; $i++) {
        if (strlen($strs[$i]) < $minlen) {
            $minx = $i;
        }
    }

    $minStr = $strs[$minx];
    unset($strs[$minx]); // 删除数组中最小的那个值
    sort($strs);
    return $minStr;
}

// 方法二
// function longestCommonPrefix($strs)
// {
//     if (empty($strs) || !is_array($strs)) {
//         return "";
//     }

//     $count = count($strs);
//     if ($count == 1) {
//         return $strs[0];
//     }

//     // 找出长度最短的字符串
//     $key = 0;
//     $min_str = $strs[0];
//     $min = strlen($min_str);
//     foreach ($strs as $k => $str) {
//         $currStrLen = strlen($str);
//         if ($min >= $currStrLen) {
//             $key = $k;
//             $min = $currStrLen;
//         }
//     }

//     $min_str = $strs[$key];
//     unset($strs[$key]);

//     $left = 1;
//     $right = strlen($min_str);
//     while ($left <= $right) {
//         $mid = floor(($right - $left) / 2) + $left;
//         if (findpre($strs, substr($min_str, 0, $mid))) {
//             $left = $mid + 1;
//         } else {
//             $right = $mid - 1;
//         }
//     }
//     return substr($min_str, 0, min($left, $right));
// }

// function findpre($strs, $pre)
// {
//     foreach ($strs as $str) {
//         if (substr($str, 0, strlen($pre)) != $pre) {
//             return false;
//         }
//     }
//     return true;
// }

// var_dump(longestCommonPrefix(["flower", "flow", "flight"]));

#***************************************************************************************************************************
# 3. 有效的括号 (编号 #20)
// 给定一个只包括 '('，')'，'{'，'}'，'['，']' 的字符串，判断字符串是否有效。
// 有效字符串需满足：
// 左括号必须用相同类型的右括号闭合。
// 左括号必须以正确的顺序闭合。
// 注意空字符串可被认为是有效字符串。

// 示例 1:
// 输入: "()"
// 输出: true

// 示例 2:
// 输入: "()[]{}"
// 输出: true

// 示例 3:
// 输入: "(]"
// 输出: false

// 示例 4:
// 输入: "([)]"
// 输出: false

// 示例 5:
// 输入: "{[]}"
// 输出: true

// 示例 6
// 输入: "["
// 输出: false

// 示例 7
// 输入: ""
// 输出: true

// 示例 8
// 输入: "[{"
// 输出: false
#***************************************************************************************************************************

// self 方法一
// function isValid($s)
// {
//     $strlength = strlen($s);
//     // 奇数长度的字符串肯定不对
//     if ($strlength % 2 == 1) {
//         return false;
//     }

//     $temp = [];
//     $left = ['(' => ')', '[' => ']', '{' => '}'];
//     for ($i = 0; $i < $strlength; $i++) { 
//         // 利用栈先进后出的特性
//         if (isset($left[$s[$i]])) {
//             array_push($temp, $s[$i]); 
//         } else {
//             $leftString = array_pop($temp);
//             if ($left[$leftString] != $s[$i]) {
//                 return false;
//             }
//         }
//     }

//     // 偶数长度的字符串也不一定对, 因为可能遇到‘{(’这样的字符串, 所以需要判断数组全部出栈后的长度，如果长度大于0说明字符串内的括号不对称, 则返回false
//     return count($temp) == 0 ? true : false; 
// }

// 方法二
// 循环消消乐。。
function isValid($s)
{
    while (true) {
        $s = str_replace(['()', '[]', '{}'], '', $s, $count);
        if ($count == 0) {
            return strlen($s) == 0;
        }
    }
}

// 递归消消乐。。
// function isValid($s) {
//       $s = str_replace(['()','[]','{}'],'',$s,$count);
//       if($count==0){
//           return strlen($s)==0;
//       }else{
//           return $this->isValid($s);
//       }
//  }

// var_dump(isValid('((()(())))'));

#***************************************************************************************************************************
# 4. 实现 strStr() (编号 #28)
// 实现 strStr() 函数。
// 给定一个 haystack 字符串和一个 needle 字符串，在 haystack 字符串中找出 needle 字符串出现的第一个位置 (从0开始)。如果不存在，则返回  -1。

// 示例 1:
// 输入: haystack = "hello", needle = "ll"
// 输出: 2

// 示例 2:
// 输入: haystack = "aaaaa", needle = "bba"
// 输出: -1

// 说明:
// 当 needle 是空字符串时，我们应当返回什么值呢？这是一个在面试中很好的问题。  
// 在项目中遇到搜索的空串应该返回false，因为数组下边都是以0开始的，如果返回0，就等于说在第一个位置找到了要搜索的字符串
// 对于本题而言，当 needle 是空字符串时我们应当返回 0 。这与C语言的 strstr() 以及 Java的 indexOf() 定义相符。
#***************************************************************************************************************************

// BF算法，即暴风(Brute Force)算法，是普通的模式匹配算法，BF算法的思想就是将目标串S的第一个字符与模式串T的第一个字符进行匹配，若相等，
// 则继续比较S的第二个字符和 T的第二个字符；若不相等，则比较S的第二个字符和T的第一个字符，依次比较下去，直到得出最后的匹配结果。BF算法是一种蛮力算法。
// 方法一
// function strStr($haystack, $needle)
// {
//     $needlelen = strlen($needle);
//     if ($needlelen == 0) {
//         return 0; // 空字符串返回0
//     }

//     $i = 0;
//     $j = 0;
//     $haystacklen = strlen($haystack);
//     while ($i < $haystacklen && $j < $needlelen) {
//         if ($haystack[$i] == $needle[$j]) {
//             $i++;
//             $j++;
//         } else {
//             $i = $i - $j + 1;
//             $j = 0;
//         }

//         if ($j == $needlelen) {
//             return $i - $j;
//         }
//     }

//     return -1;
// }

// 方法二
// function strStr($haystack, $needle)
// {
//     if ($haystack == $needle) {
//         return 0;
//     }

//     $length = strlen($haystack);
//     $n_length = strlen($needle);

//     if ($n_length <= 0) {
//         return 0;
//     }

//     if ($length <= 0) {
//         return -1;
//     }

//     if ($n_length > $length) {
//         return -1;
//     }

//     // 这里有个最大长度判断，具体设置多少不清楚，我这里设置的 1000
//     if ($length >= 1000) {
//         return -1;
//     }

//     for ($i = 0; $i < $length; $i++) {
//         $j = 0;
//         while ($haystack[$i + $j] == $needle[$j] && $j < $n_length) {
//             $j++;
//         }

//         if ($n_length == $j) {
//             return $i;
//         }
//     }

//     return -1;
// }

#***************************************************************************************************************************
# 5. 外观数列 (编号 #38)
// 「外观数列」是一个整数序列，从数字 1 开始，序列中的每一项都是对前一项的描述。前五项如下：
// 1.     1
// 2.     11
// 3.     21
// 4.     1211
// 5.     111221
// 1 被读作  "one 1"  ("一个一") , 即 11。
// 11 被读作 "two 1s" ("两个一"）, 即 21。
// 21 被读作 "one 2",  "one 1" （"一个二" ,  "一个一") , 即 1211。
// 给定一个正整数 n（1 ≤ n ≤ 30），输出外观数列的第 n 项。
// 注意：整数序列中的每一项将表示为一个字符串。

// 示例 1:
// 输入: 1
// 输出: "1"
// 解释：这是一个基本样例。

// 示例 2:
// 输入: 4
// 输出: "1211"
// 解释：当 n = 3 时，序列是 "21"，其中我们有 "2" 和 "1" 两组，"2" 可以读作 "12"，也就是出现频次 = 1 而值 = 2；类似 "1" 可以读作 "11"。
// 所以答案是 "12" 和 "11" 组合在一起，也就是 "1211"。
// TODO 读不懂题意
#***************************************************************************************************************************

// 分析题目
// 给定一个整数n（1 ≤ n ≤ 30）,输出这个整数的报数序列,报数序列为对上一个报数序列的描述,默认整数1的报数序列为 1

// 思路
// 1.两层循环解决问题
// 2.因为给定的整数n和报数序列没有关联,所以要从1开始循环,直到和给定的整数n相等,才返回对应的报数序列,这是第一层循环
// 3.在第一层的循环中,每次循环要对上一个报数序列进行描述(1 被读作 "one 1" ("一个一") , 即 11),所以要对上一个报数序列进行循环判断,这是第二层循环
// 4.在第二层循环中,利用数组进行判断,如果当前数字和数组中最后一位元素不同,则进行描述并清空数组,反之把当前数字推进数组中

function countAndSay($n)
{
    $arr = ["1"];
    for ($i = 1; $i < $n; $i++) {
        $arr[$i] = convert($arr[$i - 1]);
    }
    return $arr[$n - 1];
}

function convert($str)
{
    $ans = "";
    $count = 1;
    for ($i = 0; $i < strlen($str); $i++) {
        if (isset($str[$i + 1]) && $str[$i + 1] == $str[$i]) {
            $count++;
        } else {
            $ans = $ans . $count . $str[$i];
            $count = 1;
        }
    }
    return $ans;
}

// var_dump(countAndSay(5));


#***************************************************************************************************************************
# 6. 最后一个单词的长度 (编号 #58)
// 给定一个仅包含大小写字母和空格 ' ' 的字符串 s，返回其最后一个单词的长度。
// 如果字符串从左向右滚动显示，那么最后一个单词就是最后出现的单词。
// 如果不存在最后一个单词，请返回 0 。
// 说明：一个单词是指仅由字母组成、不包含任何空格的 最大子字符串。

// 示例1:
// 输入: "Hello World"
// 输出: 5

// 示例2:
// 输入: "a "
// 输出: 1
#***************************************************************************************************************************

// 方法一 函数法
function lengthOfLastWord($s)
{
    if (strlen($s) == 0) {
        return 0;
    }

    $strArr = explode(' ', rtrim($s));
    return strlen(end($strArr));
}

// 方法二 倒序遍历法
// function lengthOfLastWord($s)
// {
//     $count = strlen($s);
//     if ($count < 1) {
//         return 0;
//     }

//     $len = 0;
//     for ($i = $count - 1; $i >= 0; $i--) {
//         if ($s[$i] != ' ') {
//             $len++;
//         } elseif ($s[$i] == ' ' && $len != 0) {
//             break;
//         }
//     }

//     return $len;
// }

// var_dump(lengthOfLastWord("a "));


#***************************************************************************************************************************
# 7. 二进制求和 (编号 #67)
// 给定两个二进制字符串，返回他们的和（用二进制表示）。
// 输入为非空字符串且只包含数字 1 和 0。

// 示例 1:
// 输入: a = "11", b = "1"
// 输出: "100"

// 示例 2:
// 输入: a = "1010", b = "1011"
// 输出: "10101"

// 示例 2:
// 输入: 
// a = "10100000100100110110010000010101111011011001101110111111111101000000101111001110001111100001101", 
// b = "110101001011101110001111100110001010100001101011101010000011011011001011101111001100000011011110011"
// 输出: "110111101100010011000101110110100000011101000101011001000011011000001100011110011010010011000000000"
#***************************************************************************************************************************

// 错误的函数法(虽然写法简单，但是比较局限，当二进制的数值太大的时候就不合适了)
// function addBinary($a, $b) 
// {
//     return decbin(bindec($a) + bindec($b));
// }

// function addBinary($a, $b)
// {
//     $an = strlen($a);
//     $bn = strlen($b);
//     // 计算出每个字符串的长度后，进行比较，以0来填充字符串确保两个字符串位数相同
//     while ($an > $bn) {
//         $b = "0" . $b;
//         $bn++;
//     }
//     while ($an < $bn) {
//         $a = "0" . $a;
//         $an++;
//     }

//     // 从末尾开始相加，然后不断进位
//     for ($i = $an - 1; $i > 0; $i--) {
//         $a[$i] = $a[$i] + $b[$i];
//         if ($a[$i] >= 2) {
//             // 把相加之和取模2后的值赋值给当前下标对应值
//             $a[$i] = $a[$i] % 2;
//             // 顺便把前一个下标对应值先加一个进位，这样在下一轮循环的时候，该值已为新值
//             $a[$i - 1] = $a[$i - 1] + 1;
//         }
//     }

//     // 由于下标0比较特殊，可能两数相加后，会产生一个位数大1的数，则需要再连接一个字符1在字符串前，最后才是正确结果。
//     $a[0] = $a[0] + $b[0];
//     if ($a[0] >= 2) {
//         $a[0] = $a[0] % 2;
//         $a = "1" . $a;
//     }
//     return $a;
// }


// var_dump(addBinary("1111", "1"));


#***************************************************************************************************************************
# 8. 反转字符串中的元音字母 (编号 #345)
// 编写一个函数，以字符串作为输入，反转该字符串中的元音字母。
// 示例 1:
// 输入: "hello"
// 输出: "holle"

// 示例 2:
// 输入: "leetcode"
// 输出: "leotcede"

// 说明:
// 元音字母不包含字母"y"。
#***************************************************************************************************************************

// 解题思路:
// 本题为基础双指针法交换前后元音元素；
// 一般遇见字符串问题，能通过字符数组方式扫描就通过字符数组方式(方便)；
// 然后分别定义前后两个索引指针用 while 依次遍历数组；

function reverseVowels($s)
{
    if (empty($s)) {
        return '';
    }

    $startIndex = 0;
    $endIndex = strlen($s) - 1;
    $vowels = ['a' => '', 'e' => '', 'i' => '', 'o' => '', 'u' => '', 'A' => '', 'E' => '', 'I' => '', 'O' => '', 'U' => ''];
    while ($startIndex < $endIndex) {
        if (isset($vowels[$s[$startIndex]])) {
            if (isset($vowels[$s[$endIndex]]) && $startIndex != $endIndex) {
                $temp = $s[$startIndex];
                $s[$startIndex] = $s[$endIndex];
                $s[$endIndex] = $temp;
                $startIndex++;
                $endIndex--;
            } else {
                $endIndex--;
            }
        } else {
            $startIndex++;
        }
    }

    return $s;
}

// var_dump(reverseVowels("hello"));

#***************************************************************************************************************************
# 9. 检测大写字母 (编号 #520)
// 给定一个单词，你需要判断单词的大写使用是否正确。
// 我们定义，在以下情况时，单词的大写用法是正确的：
// 全部字母都是大写，比如"USA"。
// 单词中所有字母都不是大写，比如"leetcode"。
// 如果单词不只含有一个字母，只有首字母大写， 比如 "Google"。
// 否则，我们定义这个单词没有正确使用大写字母。

// 示例 1:
// 输入: "USA"
// 输出: True

// 示例 2:
// 输入: "FlaG"
// 输出: False
// 注意: 输入是由大写和小写拉丁字母组成的非空单词。
#***************************************************************************************************************************
// 方法一
// function detectCapitalUse($word) 
// {
//     if (empty($word)) {
//         return false;
//     }

//     $wordLength = strlen($word);
//     $bigCharacter = range('A', 'Z');
//     $bigCharacterIndex = 0; 
//     $bigCharacterCount = 0;
//     for ($i = 0; $i < $wordLength; $i++) { 
//         if (in_array($word[$i], $bigCharacter)) {
//             $bigCharacterIndex = $i;
//             $bigCharacterCount++;
//         }
//     }

//     if ($bigCharacterIndex == 0) {
//         return true;
//     } else if ($bigCharacterCount == 0 && $bigCharacterIndex == $wordLength - 1) {
//         return true;
//     } else if ($bigCharacterCount == $wordLength && $bigCharacterIndex == $wordLength - 1) {
//         return true;
//     } else {
//         return false;
//     }
// }

// 方法二：正则匹配
function detectCapitalUse($word) 
{
    preg_match('/^(([A-Z]+)|([A-Z]?[a-z]+))$/', $word, $matchs);
    if (empty($matchs)) {
        return false;
    }
    return true;
}


// var_dump(detectCapitalUse('Google'));























#***************************************************************************************************************************
# 1. 删去字符串中的元音
// 示例:
// 输入："leetcodeisacommunityforcoders"
// 输出："ltcdscmmntyfrcdrs"
#***************************************************************************************************************************

// $initString = 'leetcodeisacommunityforcoders';
// $endString = str_replace(array('a', 'e', 'i', 'o', 'u'), '', $initString);
// var_dump($endString);

#***************************************************************************************************************************
# 2. 宝石与石头
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
# 3. 单行键盘
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
# 4. 整数的各位积和之差
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
# 5. 给你一个有效的 IPv4 地址 address，返回这个 IP 地址的无效化版本。
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
