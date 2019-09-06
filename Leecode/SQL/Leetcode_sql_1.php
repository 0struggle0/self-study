<?php

#***************************************************************************************************************************
# 第一
# 编写一个 SQL 查询，来删除 Person 表中所有重复的电子邮箱，重复的邮箱里只保留 Id 最小 的那个。
// +----+------------------+
// | Id | Email            |
// +----+------------------+
// | 1  | john@example.com |
// | 2  | bob@example.com  |
// | 3  | john@example.com |
// +----+------------------+
// Id 是这个表的主键。
// 例如，在运行你的查询语句之后，上面的 Person 表应返回以下几行:

// +----+------------------+
// | Id | Email            |
// +----+------------------+
// | 1  | john@example.com |
// | 2  | bob@example.com  |
// +----+------------------+
#***************************************************************************************************************************

// 解法一
// DELETE FROM Person
// WHERE Id NOT IN (
// 	SELECT Id
// 	FROM (
// 		SELECT Min(Id) as Id
// 		FROM Person
// 		GROUP BY Email
// 	) as a
// )
 
// 解法二
// DELETE p1 FROM Person p1,
//     Person p2
// WHERE
//     p1.Email = p2.Email AND p1.Id > p2.Id


#***************************************************************************************************************************
# 第二
# 给定一个 Weather 表，编写一个 SQL 查询，来查找与之前（昨天的）日期相比温度更高的所有日期的 Id。
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
#***************************************************************************************************************************

// 解法一
// SELECT weather.id AS 'Id'
// FROM weather JOIN weather w 
// ON DATEDIFF(weather.RecordDate, w.RecordDate) = 1 AND weather.Temperature > w.Temperature;