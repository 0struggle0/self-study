```mysql
方法一：
select * from t1 where unix_timestamp(time1) > unix_timestamp('2011-03-03 17:39:05') and unix_timestamp(time1) < unix_timestamp('2011-03-03 17:39:52');
就是用unix_timestamp函数，将字符型的时间，转成unix时间戳。个人觉得这样比较更踏实点儿。

方法二：
time1 between '2011-03-03 17:39:05' and '2011-03-03 17:39:52';
```

