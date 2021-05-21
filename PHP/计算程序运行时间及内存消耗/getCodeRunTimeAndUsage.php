<?php

// 记录开始时间
$starttime = microtime(true);

// 记录结束时间
$endtime = microtime(true);

// 计算程序的耗时及消耗的内存
echo '耗时' . round($endtime - $starttime, 3) . '秒<br>';
echo '消耗内存: ' . memory_get_usage() / (1024 * 1024) . 'MB<br />';
