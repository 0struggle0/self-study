<?php

// $t1 = microtime(true);
// 输入三个整数 a，b，c，利用+，*，()算数操作符返回最大值。
// 数字是1,2和3，这里有一些放置标志和括号的方法：
// 1 * (2 + 3) = 5
// 1 * 2 * 3 = 6
// 1 + 2 * 3 = 7
// (1 + 2) * 3 = 9
// 所以你可以获得的最大值 是9。
// 
// 数字在（1≤a，b，c≤10）的范围内。
// 您可以多次使用相同的操作。
// 没有必要放置所有的标志和括号。
// 可能会出现数字重复。
// 你不能交换操作数。例如，在给定的示例*中，您无法获得表达式 (1 + 3) * 2 = 8。
// 
// 
// function expressionMatter($a, $b, $c) {
//   your code here
//   return max([
//         $a + $b + $c,
//         ($a + $b) * $c,
//         $a * ($b + $c),
//         $a + $b * $c,
//         $a * $b + $c,
//         $a * $b * $c
//     ]);
// }
// // 
// function expressionMatter($a, $b, $c) {
//   // your code here
//   $array = sortNumber($a, $b, $c);
//   var_dump($array);
// }

// function sortNumber($a, $b, $c)
// { 
//   $array = array($a, $b, $c);
//   sort($array, SORT_NUMERIC);
//   return $array;
// }





// function points($games){
// 	$score = 0;

// 	foreach ($games as $value) {
// 		$tempArray = explode(':', $value);
// 		if ($tempArray[0] > $tempArray[1]) {
// 			$score += 3;
// 		} else if ($tempArray[0] == $tempArray[1]) {
// 			$score += 1;
// 		} else {
// 			$score += 0;
// 		}
// 	}

// 	return $score;
// }

// $array = array('1:0','2:0','3:0','4:0','2:1','3:1','4:1','3:2','4:2','4:3');
// var_dump(points($array));

// $t2 = microtime(true);
// echo '耗时'.round($t2-$t1,3).'秒<br>';
// echo 'Now memory_get_usage: ' . memory_get_usage() . '<br />';
// 


// function createExpression($a, $b, $c)
// {
// 	$array = array('+', '-', '*', '/');
// 	$number = sortNumber($a, $b, $c);

// 	foreach ($array as $value) {
// 		foreach ($array as $value2) {
// 			echo $number[0] . $value . $number[1] . $value2 . $number[2] . '<br>';
// 			echo '(' . $number[0] . $value . $number[1] . ')' . $value2 . $number[2] . '<br>';
// 			echo $number[0] . $value . $number[1] . '(' . $value2 . $number[2] . ')' . '<br>';
// 		}
// 	}
// }

// function sortNumber($a, $b, $c)
// { 
//   $array = array($a, $b, $c);
//   sort($array, SORT_NUMERIC);
//   return $array;
// }



// 指定范围的+、-、*、/运算
// function createExpression($number, $times)
// {
// 	$count = 0;

// 	while (true) { 
// 		$numberOne = mt_rand(1, $number);
// 		$numberTwo = mt_rand(1, $number);
// 		$randomNum = mt_rand(1, 2);

// 		switch ($randomNum) {
// 			case 1:
// 				echo add($numberOne, $numberTwo);
// 				++$count;
// 				break;
// 			case 2:
// 				if ($numberOne >= $numberTwo) {
// 					echo subtract($numberOne, $numberTwo);
// 					++$count;
// 				}
// 				break;
// 			case 3:
// 				echo multiply($numberOne, $numberTwo);
// 				++$count;
// 				break;
// 			case 4:
// 				echo divide($numberOne, $numberTwo);
// 				++$count;
// 				break;
// 		}

// 		if ($count == $times) {
// 			break;
// 		}
// 	}
// }

// function add($number, $numberTwo)
// {
// 	return $number . '+' . $numberTwo . '=<br>';
// }

// function subtract($number, $numberTwo)
// {
// 	return $number . '-' . $numberTwo . '=<br>';
// }

// function multiply($number, $numberTwo)
// {
// 	return $number . '×' . $numberTwo . '=<br>';
// }

// function divide($number, $numberTwo)
// {
// 	return $number . '÷' . $numberTwo . '=<br>';
// }

// createExpression(1000, 10);


// (($i % 2) > 0) ? ++$count : 0;
// $t1 = microtime(true);

// function oddCount($n) {
// 	return intval($n / 2);
// }

// function binToDec($bin) {
// 	$count = 0;
//     $strLength = strlen($bin) - 1;
//    	for ($i = 0; $i <= $strLength; $i++) {
//    		$count += (intval($bin[$i]) * pow(2, $strLength - $i));
//    	}

//    	return $count;
// }


// Create a method is_uppercase() to see whether the string is ALL CAPS. For example:

// is_uppercase("c") == false
// is_uppercase("C") == true
// is_uppercase("hello I AM DONALD") == false
// is_uppercase("HELLO I AM DONALD") == true
// is_uppercase("ACSKLDFJSgSKLDFJSKLDFJ") == false
// is_uppercase("ACSKLDFJSGSKLDFJSKLDFJ") == true

// function is_uppercase($str) {
// 	return (strtoupper($str) == $str) ? true : false;
// }

// function solution($str) {
// 	return strrev($str);
// }

// function fake_bin($s){
// 	$strLength = strlen($s);
// 	for ($i = 0; $i < $strLength; $i++) { 
// 		$s[$i] = ($s[$i] >= 5) ?  1 : 0;
// 	}

// 	return $s;
// }

// var_dump(fake_bin('45385593107843568'));

// '01011110001100111'  '45385593107843568'


// function elevator($left, $right, $call) {
// 	$leftDistice = abs($left - $call);
// 	$RighttDistice = abs($right - $call);
// 	if ($leftDistice < $RighttDistice) {
// 		return "left";
// 	} else if ($leftDistice > $RighttDistice) {
// 		return "right";
// 	} else {
// 		return "right";
// 	}
// }

// var_dump(elevator(0, 0, 0));


// function goals ($laLigaGoals, $copaDelReyGoals, $championsLeagueGoals){
// 	// return $laLigaGoals + $copaDelReyGoals + $championsLeagueGoals;
// 	return array_sum(func_get_args());
// }

// var_dump(goals(5,10,2));

function getChar($c)
{
//   return chr($c);
	return ord($c);
}

// var_dump(getChar('u'));

// 

// The geese are any strings in the following array, which is pre-populated in your solution:

// $geese = ["African", "Roman Tufted", "Toulouse", "Pilgrim", "Steinbacher"];
// For example, if this array were passed as an argument:

// ["Mallard", "Hook Bill", "African", "Crested", "Pilgrim", "Toulouse", "Blue Swedish"]
// Your function would return the following array:

// ["Mallard", "Hook Bill", "Crested", "Blue Swedish"]

// geese

// function gooseFilter($birds)
// {
//   $geese = ["African", "Roman Tufted", "Toulouse", "Pilgrim", "Steinbacher"];
//   return array_values(array_diff($birds, $geese));
// }

// $this->assertEquals(["Mallard", "Hook Bill", "Crested", "Blue Swedish"], gooseFilter(["Mallard", "Hook Bill", "African", "Crested", "Pilgrim", "Toulouse", "Blue Swedish"]));
// $this->assertEquals(["Mallard", "Barbary", "Hook Bill", "Blue Swedish", "Crested"], gooseFilter(["Mallard", "Barbary", "Hook Bill", "Blue Swedish", "Crested"]));
// $this->assertEquals([], gooseFilter(["African", "Roman Tufted", "Toulouse", "Pilgrim", "Steinbacher"]));

// function isVow( $a)
// {
//     $array = array('97' => 'a','101' => 'e', '105' => 'i','105' => 'i','111' => 'o','117' => 'u');
// 	return array_map(function($value) use ($array) {return empty($array[$value]) ? $value : $array[$value];}, $a);
// }

// var_dump(isVow(array(117,97,107,117)));

// function orderedCount($text) 
// {
// 	$strAndCount = array_count_values(str_split($text));
	
// 	array_walk($strAndCount, function(&$value, $key){
// 		$value = array($key, $value);
// 	});

// 	$strAndCount = array_values($strAndCount);

// 	return $strAndCount;
// }

// var_dump(orderedCount('abracadabra'));

// function nextHappyYear($year) 
// {
// 	while (true) {
// 		$year = ++$year;
// 		$filterYearNum = array_unique(str_split(strval($year)));
// 		if (count($filterYearNum) == 4) {
// 			return $year;
// 		}
// 	}
// }

// $this->assertEquals(1023, nextHappyYear(1001));
// $this->assertEquals(1203, nextHappyYear(1123));
// $this->assertEquals(2013, nextHappyYear(2001));
// $this->assertEquals(2340, nextHappyYear(2334));
// $this->assertEquals(3401, nextHappyYear(3331));
// $this->assertEquals(2013, nextHappyYear(1987));
// $this->assertEquals(5601, nextHappyYear(5555));
// $this->assertEquals(7801, nextHappyYear(7712));
// $this->assertEquals(8091, nextHappyYear(8088));
// $this->assertEquals(9012, nextHappyYear(8999));

// var_dump(nextHappyYear(1987));

function containAllRots($s, $arr) 
{
	// $s = sortStr($s);
	// $judgeNumber = array_map(function($value) use($s){
	// 	return (sortStr($value) == $s) ? 1 : 0;
	// }, $arr);
	// foreach ($arr as $value) {
	// 	similar_text($s, $value, $percent);
	// 	if ($percent != 100) {
	// 		return false;
	// 	}
	// }

	// return $judgeNumber;
}

// function disorganize($string)
// {
// 	$array = array();
// 	$number = 1;
// 	while (true) {
// 		if ($number > 1000) {
// 			break;
// 		}

// 		if ($number == 1) {
// 			$array[] = $string;
// 		} else {
// 			$tempStr = str_shuffle($string);
// 			if (!in_array($tempStr, $array)) {
// 				$array[] = $tempStr;
// 			}
// 		}

// 		++$number;
// 	}
// }

// var_dump(containAllRots("bsjq", array("bsjq", "qbsj", "sjqb", "twZNsslC", "jqbs")));
// var_dump(containAllRots("XjYABhR", array("TzYxlgfnhf", "yqVAuoLjMLy", "BhRXjYA", "YABhRXj", "hRXjYAB", "jYABhRX", "XjYABhR", "ABhRXjY")));
// var_dump(containAllRots("QJAhQmS", array("hQmSQJA", "QJAhQmS", "QmSQJAh", "yUgUXoQE", "AhQmSQJ", "mSQJAhQ", "SQJAhQm", "JAhQmSQ")));
// $this->revTest(containAllRots("bsjq", 
// ["bsjq", "qbsj", "sjqb", "twZNsslC", "jqbs"]), true);
// $this->revTest(containAllRots("XjYABhR", 
// ["TzYxlgfnhf", "yqVAuoLjMLy", "BhRXjYA", "YABhRXj", "hRXjYAB", "jYABhRX", "XjYABhR", "ABhRXjY"]), false);
// $this->revTest(containAllRots("QJAhQmS", 
// ["hQmSQJA", "QJAhQmS", "QmSQJAh", "yUgUXoQE", "AhQmSQJ", "mSQJAhQ", "SQJAhQm", "JAhQmSQ"]), true);



// $t2 = microtime(true);
// echo '耗时'.round($t2-$t1,3).'秒<br>';
// echo 'Now memory_get_usage: ' . memory_get_usage() . '<br />';

// function nbYear($p0, $percent, $aug, $p) {
// 	$people = floor($p0 + $p0 * $percent / 100 + $aug);
// 	$year = 1;
//     while ($people < $p) {
//     	$people = $people + $people * $percent / 100 + $aug;
//     	++$year;
//     }

//     return $year;
// }

// var_dump(nbYear(1500000, 2.5, 10000, 2000000));
// 
// 

// function solve($s) {  
// 	$prefix = getPrefix($s); //前缀
// 	$suffix = getSuffix($s); //后缀

// 	var_dump($prefix);
// 	var_dump($suffix);

// 	return count(array_intersect($prefix, $suffix));
// }


// var_dump(solve('aaaa'));

// function getPrefix($s)
// {
// 	$prefixArray = array();
// 	$prefixString = '';
// 	$sLength = strlen($s);
// 	for ($i = 0; $i < $sLength - 1; $i++) { 
// 		$prefixString .= $s[$i];
// 		$prefixArray[] = $prefixString;
// 	}

// 	return $prefixArray;
// }

// function getSuffix($s)
// {
// 	$suffixArray = array();
// 	$suffixString = '';
// 	$sLength = strlen($s);
// 	$count = 1;

// 	while ($sLength > 1) {
// 		for ($i = $count; $i < strlen($s); $i++) {
// 			$suffixString .= $s[$i];
// 		}

// 		$suffixArray[] = $suffixString;
// 		$suffixString = '';
// 		$sLength--;
// 		$count++;
// 	}
	

// 	return $suffixArray;
// }


// function solve($s) 
// {  
//   $r=0;
//   $i=0;
//   $l=strlen($s);
//   while($i < floor($l/2)){
// 	$i++;
// 	$temp = substr($s,0,$i);
// 	$temp2 = substr($s,$l-$i);
//     if($temp == $temp2){
//       $r=$i;
//     }
//   }
//   return $r;
// }

// function solve($s) {  
// 	$longest = 0;
// 	for ($i = 0; $i < strlen($s); $i++) {
// 	  $sliced = substr($s, 0, $i);
// 	  $pos = strrpos($s, $sliced);
// 	  if (substr($s, -strlen($sliced)) === $sliced && ($pos === false ? -1 : $pos) > $i - 1) $longest = $i;
// 	}
// 	return $longest;
//   }

// var_dump(solve('abcdabc'));

// function monkeyCount($n) {
// 	return range(1, $n);
// }


// $this->assertEquals([4, 3, 1], solve(["abode", "ABc", "xyzD"]));
// $this->assertEquals([4, 3, 0], solve(["abide", "ABc", "xyz"]));
// $this->assertEquals([6, 5, 7], solve(["IAMDEFANDJKL", "thedefgh", "xyzDEFghijabc"]));
// $this->assertEquals([1, 3, 1, 3], solve(["encode", "abc", "xyzD", "ABmD"]));
// $this->assertEquals([], solve([]));
// solve(["abode","ABc","xyzD"]) = [4, 3, 1]

// var_dump(solve(["encode", "abc", "xyzD", "ABmD"]));
// solve(["abode", "ABc", "xyzD"]);

// function invite_more_women(array $a){
// 	return (array_sum($a) <= 0) ? false : true;
// }

// $this->assertTrue(invite_more_women([1, -1, 1]));
// $this->assertTrue(invite_more_women([1, 1, 1]));
// $this->assertFalse(invite_more_women([-1, -1, -1]));
// $this->assertFalse(invite_more_women([1, -1]));

// var_dump(invite_more_women([-1, -1, -1]));



// $temp = "Arg的&lt;!-- MathType@Translator@5@5@MathML3 (no namespace).tdl@MathML 3.0 (no namespace)@ --&gt;&lt;math display='block'&gt;&lt;semantics&gt;&lt;mrow&gt;&lt;mtext&gt;pK&lt;msup&gt;1&lt;mo&gt;&amp;#x2032;&lt;/mo&gt;&lt;/msup&gt;
//     =2&lt;/mtext&gt;&lt;mtext&gt;.17&lt;/mtext&gt;&lt;/mrow&gt;&lt;/semantics&gt;&lt;/math&gt;&lt;!-- MathType@End@5@5@ --&gt;
//    ,&lt;!-- MathType@Translator@5@5@MathML3 (no namespace).tdl@MathML 3.0 (no namespace)@ --&gt;&lt;math display='block'&gt;&lt;semantics&gt;&lt;mrow&gt;&lt;mtext&gt;pK&lt;msup&gt;2&lt;mo&gt;&amp;#x2032;&lt;/mo&gt;&lt;/msup&gt;
//     =9&lt;/mtext&gt;&lt;mtext&gt;.04&lt;/mtext&gt;&lt;/mrow&gt;&lt;/semantics&gt;&lt;/math&gt;&lt;!-- MathType@End@5@5@ --&gt;
//    ,&lt;!-- MathType@Translator@5@5@MathML3 (no namespace).tdl@MathML 3.0 (no namespace)@ --&gt;&lt;math display='block'&gt;&lt;semantics&gt;&lt;mrow&gt;&lt;mtext&gt;pK&lt;msup&gt;3&lt;mo&gt;&amp;#x2032;&lt;/mo&gt;&lt;/msup&gt;
//     =12&lt;/mtext&gt;&lt;mtext&gt;.48&lt;/mtext&gt;&lt;/mrow&gt;&lt;/semantics&gt;&lt;/math&gt;&lt;!-- MathType@End@5@5@ --&gt;
//    ,其&lt;!-- MathType@Translator@5@5@MathML3 (no namespace).tdl@MathML 3.0 (no namespace)@ --&gt;&lt;math display='block'&gt;&lt;semantics&gt;&lt;mrow&gt;&lt;mtext&gt;p&lt;msup&gt;I&lt;mo&gt;&amp;#x2032;&lt;/mo&gt;&lt;/msup&gt;&lt;/mtext&gt;&lt;/mrow&gt;
//    &lt;/semantics&gt;&lt;/math&gt;&lt;!-- MathType@End@5@5@ --&gt;等于( )。";

//    echo htmlspecialchars_decode($temp);
//    

// function NthSmallest($arr, $pos)
// {
// 	sort($arr, SORT_NUMERIC);
// 	return $arr[$pos - 1];
// }

// function save($sizes, $hd) {
// 	$sumFileSize = 0;
// 	$fileCount = 0;

// 	foreach ($sizes as $fileIndex => $fileSize) {
// 		$sumFileSize += $fileSize;

// 		if ($sumFileSize > $hd) {
// 			break;
// 		} else {
// 			$fileCount++;
// 		}
// 	}

// 	return $fileCount;
// }

// var_dump(save([4, 8, 15, 16, 23, 42], 108));



// function driver($data) 
// {	
// 	$name = getPartName($data);
// 	$date = getMyDate($data);
// 	$anotherName = getLNameAndMidFirstLetter($data);
// 	return $name . $date . $anotherName . '9AA';
// }

// function getPartName($data)
// {
// 	$name = strtoupper(substr($data[2], 0, 5));
// 	$nameLength = strlen($name);
// 	if ($nameLength < 5) {
// 		$nameArray = str_split($name);
// 		$fillCount = 5 - $nameLength;
// 		$nameArray = array_merge($nameArray, array_fill($nameLength, $fillCount, '9'));
// 		$name = implode('', $nameArray);
// 	}

// 	return $name;
// }

// function getMyDate($data)
// {
// 	$dataArray = explode('-', $data[3]);
// 	$singYearNumber = getYear($dataArray);
// 	$month = getMonth($dataArray);

// 	if ($data[4] == 'F') {
// 		$month = strval($month + 50);
// 	} else if ($data[4] == 'M' && $month < 10) {
// 		$month = '0' . $month;
// 	}

// 	$day = getDay($dataArray);

// 	return $singYearNumber[0] . $month . $day . $singYearNumber[1];
// }

// function getYear($dataArray)
// {
// 	return substr($dataArray[2], 2);
// }

// function getMonth($dataArray)
// {
// 	$months = array('Jan' => '1', 'Feb' => '2', 'Mar' => '3', 'Apr' => '4', 'May' => '5', 'June' => '6', 'July' => '7', 'Aug' => '8', 'Sept' => '9', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12');
// 	$temp = substr($dataArray[1], 0, 3);
// 	$anotherTemp = substr($dataArray[1], 0, 4);
// 	if (array_key_exists($temp, $months)) {
// 		return $months[$temp];
// 	} else if (array_key_exists($anotherTemp, $months)) {
// 		return $months[$anotherTemp];
// 	}
// }

// function getDay($dataArray)
// {
// 	return $dataArray[0];
// }

// function getLNameAndMidFirstLetter($data)
// {
// 	$lNameFirst = ($data[0] != '') ?  $data[0][0] : '9';
// 	$middleFirst = ($data[1] != '') ?  $data[1][0] : '9';
// 	$temp = $lNameFirst . $middleFirst;
// 	return $temp;
// }

// class MyTestCases extends TestCase {
//     public function testExample() {
//       $data = ["John","James","Smith","01-Jan-2000","M"];
//       $this->assertEquals("SMITH001010JJ9AA", driver($data), "Should return 'SMITH001010JJ9AA'");
      
//       $data = ["Johanna","","Gibbs","13-Dec-1981","F"];
//       $this->assertEquals("GIBBS862131J99AA", driver($data), "Should return 'GIBBS862131J99AA'");
      
//       $data = ["Andrew","Robert","Lee","02-September-1981","M"];
//       $this->assertEquals("LEE99809021AR9AA", driver($data), "Should return 'LEE99809021AR9AA'");
//     }
// }

// MCCUL 7 57 12 8JI9AA
// MCCUL 7 50 12 8JI9AA

// $data = ["John","James","Smith","01-Jan-2000","M"];
// $this->assertEquals("SMITH001010JJ9AA", driver($data), "Should return 'SMITH 0 01 01 0 JJ 9 AA'");
                                                                        
// $data = ["Johanna","","Gibbs","13-Dec-1981","F"];
// $this->assertEquals("GIBBS862131J99AA", driver($data), "Should return 'GIBBS 8 62 13 1 J9 9 AA'");

// $data = ["Andrew","Robert","Lee","02-September-1981","M"];
// $this->assertEquals("LEE99809021AR9AA", driver($data), "Should return 'LEE99 8 09 02 1 AR 9 AA'");
// 
// $temp = $name . $date . $anotherName . '9AA';
// var_dump($name . $date . $anotherName . '9AA');

// error_log(print_r('条件：', 1));
// error_log(print_r($condition, 1));
// error_log(print_r('试题id：', 1));
// error_log(print_r($result, 1));

// function getMiddle($text) {
// 	if () {
// 		# code...
// 	}
// }

// 2332
// 110011
// 54322345



// function palindrome($num) {
//   if (gettype($num) != "integer" || $num < 0) return "Not valid";
//   $a = array_reverse(str_split($num));
//   $b = str_split($num);
//   return(array_reverse(str_split($num)) == str_split($num) );
// }

// function palindrome($num) {
// 	if (!is_int($num) || $num < 0) {
// 		return 'Not valid';
// 	}

// 	return $num == strrev($num);
// }

 // var_dump(palindrome(1221));
//  class NumericalPalindrome1Test extends TestCase {
// 	public function testExamples() {
// 	  $this->assertTrue(palindrome(1221));
// 	  $this->assertFalse(palindrome(123322));
// 	  $this->assertEquals("Not valid", palindrome("ACCDDCCA"));
// 	  $this->assertEquals("Not valid", palindrome("1221"));
// 	  $this->assertEquals("Not valid", palindrome(-450));
// 	}
//   }

// function removeDuplicateWords($s) {
// 	return implode(' ' , array_unique(explode(' ', $s)));
// }


    // public function testBasics() {        
    //     $this->dotest("Alexis:Wahl;John:Bell;Victoria:Schwarz;Abba:Dorny;Grace:Meta;Ann:Arno;Madison:STAN;Alex:Cornwell;Lewis:KERN;Megan:Stan;Alex:Korn", 
    //         "(ARNO, ANN)(BELL, JOHN)(CORNWELL, ALEX)(DORNY, ABBA)(KERN, LEWIS)(KORN, ALEX)(META, GRACE)(SCHWARZ, VICTORIA)(STAN, MADISON)(STAN, MEGAN)(WAHL, ALEXIS)");
    //     $this->dotest("John:Gates;Michael:Wahl;Megan:Bell;Paul:Dorries;James:Dorny;Lewis:Steve;Alex:Meta;Elizabeth:Russel;Anna:Korn;Ann:Kern;Amber:Cornwell", 
    //         "(BELL, MEGAN)(CORNWELL, AMBER)(DORNY, JAMES)(DORRIES, PAUL)(GATES, JOHN)(KERN, ANN)(KORN, ANNA)(META, ALEX)(RUSSEL, ELIZABETH)(STEVE, LEWIS)(WAHL, MICHAEL)");
        
    // }


// function meeting($s) {
    
// }

// var_dump(capitalize("codingisafunactivity"));
// 


// function solve($s) 
// {
// 	preg_match_all('/\d+/', $s, $match);
// 	return max($match[0]);
// }

// solve('lu1j8qbbb85');
// var_dump(solve('gh12cdy695m1'));

// $this->assertEquals(695, solve('gh12cdy695m1'));
// $this->assertEquals(9, solve('2ti9iei7qhr5'));
// $this->assertEquals(61, solve('vih61w8oohj5'));
// $this->assertEquals(42, solve('f7g42g16hcu5'));
// $this->assertEquals(85, solve('lu1j8qbbb85'));





// function is_palindrome($line) 
// {
// 	return (strrev($line) == $line) ? true : false;
// }

// var_dump(is_palindrome(123456));
// isPalindrome("anna")   ==> true
// isPalindrome("walter") ==> false
// isPalindrome(12321)    ==> true
// isPalindrome(123456)   ==> false


// function nthEven($n) 
// {
// 	return $n * 2 - 2;
// }

// var_dump(nthEven(1298734));

// nthEven(1) //=> 0, the first even number is 0
// nthEven(3) //=> 4, the 3rd even number is 4 (0, 2, 4)

// nthEven(100) //=> 198
// nthEven(1298734) //=> 2597466
// 

// 给定一个 Weather 表，编写一个 SQL 查询，来查找与之前（昨天的）日期相比温度更高的所有日期的 Id。

// +---------+------------------+------------------+
// | Id(INT) | RecordDate(DATE) | Temperature(INT) |
// +---------+------------------+------------------+
// |       1 |       2015-01-01 |               10 |
// |       2 |       2015-01-02 |               25 |
// |       3 |       2015-01-03 |               20 |
// |       4 |       2015-01-04 |               30 |
// +---------+------------------+------------------+
// 例如，根据上述给定的 Weather 表格，返回如下 Id:

// +----+
// | Id |
// +----+
// |  2 |
// |  4 |
// +----+



// function findDifference($a, $b) 
// {
// 	$productA = array_product($a);
// 	$productB = array_product($b);

// 	return abs($productA - $productB);
// }

// var_dump(findDifference(array(3, 2, 5), array(1, 4, 4)));

function flatten_and_sort($array) 
{
	$result = array();
	foreach ($array as $value) {
		$result = array_merge($result, $value);
	}

	sort($result);
	return $result;
}

var_dump(flatten_and_sort(array(array(3, 2, 1), array(4, 6, 5), array(), array(9, 7, 8))));
// flatten_and_sort([[], []])=>[]
// flatten_and_sort([[], [1]])=>[1]
// flatten_and_sort([[], [], [], [2], [], [1]])=>[1, 2]
// flatten_and_sort([[3, 2, 1], [7, 9, 8], [6, 4, 5]])=>[1, 2, 3, 4, 5, 6, 7, 8, 9]
// flatten_and_sort([[1, 3, 5], [100], [2, 4, 6]])=>[1, 2, 3, 4, 5, 6, 100]
// flatten_and_sort([[111, 999], [222], [333], [444], [888], [777], [666], [555]])=>[111, 222, 333, 444, 555, 666, 777, 888, 999]
