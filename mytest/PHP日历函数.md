```php
$year = 2020;
$month = 7;
$day = '6';

$num = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 返回某个历法中某年中某月的天数
echo "There was $num days in $month $year<br>";

$julianDay = gregoriantojd($month, $day, $year); // 转变一个Gregorian历法日期到Julian Day计数
$weekDay = jddayofweek($julianDay, 1); // 返回日期在周几
echo "$year 年 $month 月 $day 日 is $weekDay<br>"; // 第二参数设置为1 返回英文单词形式 Monday

echo jdmonthname($julianDay, 1); // 返回月的名称
```

