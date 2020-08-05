<?php

function returnLetter($number) {
    if ($number <= 0) return false;
    $flag = '';
    $result = '';
    $lastIndex = 26;
    $array = array(
        1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J',
        11 => 'K',12  => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T',
        21 => 'U',22  => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z'
    );

    $divisor = floor($number / 26); //除数
    $remainder = floor($number % 26); //余数

    var_dump('除数：'.$divisor);
    var_dump('余数：'.$remainder);

    if ($divisor == 0 && $remainder > 0) {
        $flag .= $array[$remainder]; // 1-25
    } elseif ($divisor >= 1 && $divisor <= 27) {  //大于26
        if ($remainder > 0) {   //大于26,但不是26的倍数
            if ($divisor == 27) {
                $result .= returnLetter($divisor);
                if ($result) {
                    $flag .= $result;
                }
                $flag .= $array[$remainder];
            } else {
                $flag .= $array[$divisor];
                $flag .= $array[$remainder];
            }
        } elseif ($remainder == 0) {  //26的倍数
            $flag .= $array[$divisor - 1];
            for ($i = $divisor - 2; $i < $divisor - 1; $i++) {
                $flag .= $array[$lastIndex];
            }
        }
    } elseif ($divisor > 27) { //比26的26倍还要大的数字
        $result .= returnLetter($divisor);
        if ($result) {
            $flag .= $result;
        }

        var_dump('result:'.$result);
    }


    return $flag;
}

echo returnLetter(702);
echo "<br>";

class foo
{
    function do_foo()
    {
        echo "Doing foo."; 
    }
}

$bar = new foo;
$bar->do_foo();
