<?php 
// function xrange($start, $end, $step = 1) {}
//     for ($i = $start; $i <= $end; $i += $step) {
//         yield $i;
//     }
// }

// $tmp = xrange(1, 1000000);
// // var_dump(gettype($tmp));
// // $arr = is_object($tmp) ? get_object_vars($tmp) : $tmp;
// $tmp->rewind();
// var_dump($tmp->current());
// $tmp->next();
// var_dump($tmp->current());

// foreach (xrange(1, 1000000) as $num) {
//     echo $num, "\n";
// }


// function &gen_reference() {
//     $value = 3;

//     while ($value > 0) {
//         yield $value;
//     }
// }

 
//  * 我们可以在循环中修改$number的值，而生成器是使用的引用值来生成，所以gen_reference()内部的$value值也会跟着变化。
 
// foreach (gen_reference() as &$number) {
//     echo (--$number).'... ';
// }

// var_dump(foo(bar()));

// var_dump($d);
// function gen() {
//     $ret = (yield 'yield1');
//     var_dump($ret);
//     $ret = (yield 'yield2');
//     var_dump($ret);
// }
 
// $gen = gen();
// var_dump($gen->current());    // string(6) "yield1"
// var_dump($gen->send('ret1')); // string(4) "ret1"   (the first var_dump in gen) 相当于数组中指针自动往下移动了一位
// // ;                              // string(6) "yield2" (the var_dump of the ->send() return value)
// var_dump($gen->send('ret2')); // string(4) "ret2"   (again from within gen)
//                               // NULL               (the return value of ->send())


echo "string".PHP_EOL;
echo "alsdkjfla";