<?php

$t1 = microtime(true);
// ... 执行代码 ...
$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3).'秒<br>';
echo 'Now memory_get_usage: ' . memory_get_usage() . '<br />';

 



// microtime() 加上 true 参数, 返回的将是一个浮点类型. 这样 t1 和 t2 得到的就是两个浮点数, 相减之后得到之间的差. 由于浮点的位数很长, 或者说不确定, 所以使用 round() 取出小数点后 3 位。

// memory_get_usage() 返回的单位是b,/1024得到kb,/(1024*1024)得到mb，依次类推。