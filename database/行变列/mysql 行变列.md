# mysql 行变列

#### 多行变成一行/多行合并成一行/多行合并成多列/合并行，其实是一个意思

数据库结构如图： 

![1](D:\xampp\htdocs\mytest\Git\self-study\database\行变列\image\1.png)

而我想让同一个人的不同成绩变成此人在这一行不同列上显示出来，此时分为2中展现：

**第一种**展现如图----【多行变一列】（合并后的数据在同一列上）：

![2](D:\xampp\htdocs\mytest\Git\self-study\database\行变列\image\2.png)

sql如下： 

```sql
select name ,group_concat(sore Separator ';') as score from stu group by name 
```



**第二种**展现如图----【多行变多列】（合并后的数据在不同列上）： 

![3](D:\xampp\htdocs\mytest\Git\self-study\database\行变列\image\3.png)

sql如下：

```sql
SELECT name ,
MAX(CASE type WHEN '数学' THEN score ELSE 0 END ) math,
MAX(CASE type WHEN '英语' THEN score ELSE 0 END ) English ,
MAX(CASE type WHEN '语文' THEN score ELSE 0 END ) Chinese 
FROM stu  
GROUP BY name
```



当然，在第一种情况中（显示在一列），也有些其他的类似形式：

形式一：

![4](D:\xampp\htdocs\mytest\Git\self-study\database\行变列\image\4.png)

sql如下： 

```sql
select name,
group_concat(type,'分数为:',score  Separator '; ') as score 
from stu 
group by name 
```

当然 如果你很熟悉group_concat和concat的用法，你也做出如下形式： 

![5](D:\xampp\htdocs\mytest\Git\self-study\database\行变列\image\5.png)

其sql如下： 

```sql
select name ,concat(name ,'的分数为[',group_concat(type,'分数为:',score  Separator '; '),']') as score from stu group by name 
```

