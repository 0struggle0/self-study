```sql
create table #temp(
 qty decimal(12,4)
)
  
insert into #temp
select 1
union select 1.12
union select 1.234
union select 1.2342
union select 1.3
 
select case 
when right(qty,4)='0000' then left(qty,len(qty)-5)
when right(qty,3)='000' then left(qty,len(qty)-3)
when right(qty,2)='00' then left(qty,len(qty)-2)
when right(qty,2)<>'00' and right(qty,1)='0' then left(qty,len(qty)-1)
else left(qty,len(qty)) end "查询结果",qty "原数据" from #temp
 
drop table #temp
 
查询结果    原数据
1    1.0000
1.12    1.1200
1.234    1.2340
1.2342    1.2342
1.3    1.3000
```

