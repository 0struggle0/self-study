<?php

// 记录开始时间
$starttime = getMicrotime();

// 记录结束时间
$endtime = getMicrotime();

// 计算程序的耗时及消耗的内存
echo '耗时:'.(float)(($endtime-$starttime)*1000).'ms<br>';
echo '消耗内存: ' . memory_get_usage() / (1024 * 1024) . 'MB<br />';