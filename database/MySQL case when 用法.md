## MySQL case when 用法

MySQL 的 case when 的语法有两种：

1. 简单函数 
   `CASE [col_name] WHEN [value] THEN [result]…ELSE [default] END`
2. 搜索函数 
   `CASE WHEN [expr] THEN [result]…ELSE [default] END`



### 简单函数

`CASE [col_name] WHEN [value] THEN [result]…ELSE [default] END`： 枚举这个字段所有可能的值*

```sql
SELECT 
	`name` AS '英雄',
	CASE `name`
		WHEN '德莱文' 
			THEN '斧子'
		WHEN '德玛西亚-盖伦'
			THEN '大宝剑'
		WHEN '暗夜猎手-VN'
			THEN '弩'
		ELSE 
			'无'
	END AS'装备'
FROM `hero`;
```



### 搜索函数

`CASE WHEN [expr] THEN [result]…ELSE [default] END`：搜索函数可以写判断，并且搜索函数只会返回第一个符合条件的值，其他`case`被忽略

```sql
-- when 表达式中可以使用 and 连接条件
SELECT
    `name` AS '英雄',
    age AS '年龄',
    CASE
        WHEN age < 18 THEN
            '少年'
        WHEN age < 30 THEN
            '青年'
        WHEN age >= 30     
        AND age < 50 THEN
            '中年'
        ELSE
            '老年'
    END AS '状态'
FROM `hero`
```



###  case when 的简单函数实现行转列

```sql
-- 聚合函数 sum 配合 case when 的简单函数实现行转列
SELECT
	student.stu_id '学号',
	student.stu_name '姓名',
	sum( CASE courses.course_name WHEN '大学语文' THEN score.scores ELSE 0 END ) '大学语文',
	sum( CASE courses.course_name WHEN '新视野英语' THEN score.scores ELSE 0 END ) '新视野英语',
	sum( CASE courses.course_name WHEN '离散数学' THEN score.scores ELSE 0 END ) '离散数学',
	sum( CASE courses.course_name WHEN '概率论与数理统计' THEN score.scores ELSE 0 END ) '概率论与数理统计',
	sum( CASE courses.course_name WHEN '线性代数' THEN score.scores ELSE 0 END ) '线性代数',
	sum( CASE courses.course_name WHEN '高等数学' THEN score.scores ELSE 0 END ) '高等数学'
FROM
	edu_student student
	LEFT JOIN edu_score score ON student.stu_id = score.stu_id
	LEFT JOIN edu_courses courses ON courses.course_no = score.course_no 
GROUP BY
	student.stu_id 
```



### 建表语句

```sql
CREATE TABLE `hero` (
  `id` int(11) NOT NULL,
  `name` char(255) CHARACTER SET utf8mb4 NOT NULL,
  `age` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 创建表  学生表
CREATE TABLE `edu_student` (
    `stu_id` VARCHAR (16) NOT NULL COMMENT '学号',
    `stu_name` VARCHAR (20) CHARACTER SET utf8mb4 NOT NULL COMMENT '学生姓名',
    PRIMARY KEY (`stu_id`)
) COMMENT = '学生表' ENGINE = INNODB DEFAULT CHARSET=utf8mb4;

-- 课程表 
CREATE TABLE `edu_courses` (
    `course_no` VARCHAR (20) NOT NULL COMMENT '课程编号',
    `course_name` VARCHAR (100) CHARACTER SET utf8mb4 NOT NULL COMMENT '课程名称',
    PRIMARY KEY (`course_no`)
) COMMENT = '课程表' ENGINE = INNODB DEFAULT CHARSET=utf8mb4;

-- 成绩表
CREATE TABLE `edu_score` (
    `stu_id` VARCHAR (16) NOT NULL COMMENT '学号',
    `course_no` VARCHAR (20) NOT NULL COMMENT '课程编号',
    `scores` FLOAT NULL DEFAULT NULL COMMENT '得分',
    PRIMARY KEY (`stu_id`, `course_no`)
) COMMENT = '成绩表' ENGINE = INNODB DEFAULT CHARSET=utf8mb4;
```

### 插入数据

```sql
-- 学生表数据
INSERT INTO edu_student (stu_id, stu_name)
VALUES
    ('1001', '盲僧'),
    ('1002', '赵信'),
    ('1003', '皇子'),
    ('1004', '寒冰'),
    ('1005', '蛮王'),
    ('1006', '狐狸');

-- 课程表数据 
INSERT INTO edu_courses (course_no, course_name)
VALUES
    ('C001', '大学语文'),
    ('C002', '新视野英语'),
    ('C003', '离散数学'),
    ('C004', '概率论与数理统计'),
    ('C005', '线性代数'),
    ('C006', '高等数学');

-- 成绩表数据
INSERT INTO edu_score (stu_id, course_no, scores)
VALUES
    ('1001', 'C001', 67), 
    ('1002', 'C001', 68),   
    ('1003', 'C001', 69),   
    ('1004', 'C001', 70),   
    ('1005', 'C001', 71),
    ('1006', 'C001', 72),   
    ('1001', 'C002', 87),   
    ('1002', 'C002', 88),   
    ('1003', 'C002', 89),   
    ('1004', 'C002', 90),
    ('1005', 'C002', 91),   
    ('1006', 'C002', 92),   
    ('1001', 'C003', 83),   
    ('1002', 'C003', 84),   
    ('1003', 'C003', 85),
    ('1004', 'C003', 86),   
    ('1005', 'C003', 87),   
    ('1006', 'C003', 88),   
    ('1001', 'C004', 88),   
    ('1002', 'C004', 89),
    ('1003', 'C004', 90),   
    ('1004', 'C004', 91),   
    ('1005', 'C004', 92),   
    ('1006', 'C004', 93),   
    ('1001', 'C005', 77),
    ('1002', 'C005', 78),   
    ('1003', 'C005', 79);
```

