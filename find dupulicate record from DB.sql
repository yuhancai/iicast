��Ե�ǰ
select * from tbl_draws  
where itemid=6 and qishu in (select qishu from tbl_draws where itemid=6 group by qishu having count(qishu) > 1) order by qishu


delete from tbl_draws
where itemid=6 and qishu in (select qishu from tbl_draws where itemid=6 group by qishu having count(qishu) > 1)
and id not in (select min(id) from tbl_draws where itemid=6 group by qishu having count(qishu) > 1)

sql for sqlite
select *,strftime('%H',begin_at) from tbl_draws where abs(strftime('%H',begin_at))<abs(strftime('%H',datetime('now','+8 hours'))) and abs(strftime('%H',begin_at))=8



SQL�ظ���¼��ѯ(ת��)
 1�����ұ��ж�����ظ���¼���ظ���¼�Ǹ��ݵ����ֶΣ�peopleId�����ж�
select * from people
where peopleId in (select  peopleId  from  people  group  by  peopleId  having  count(peopleId) > 1)
 ������
 select * from testtable
 where numeber in (select number from people group by number having count(number) > 1 )
 ���Բ��testtable����number��ͬ�ļ�¼

2��ɾ�����ж�����ظ���¼���ظ���¼�Ǹ��ݵ����ֶΣ�peopleId�����жϣ�ֻ����rowid��С�ļ�¼
delete from people 
where peopleId  in (select  peopleId  from people  group  by  peopleId   having  count(peopleId) > 1)
and rowid not in (select min(rowid) from  people  group by peopleId  having count(peopleId )>1)

3�����ұ��ж�����ظ���¼������ֶΣ� 
select * from vitae a
where (a.peopleId,a.seq) in  (select peopleId,seq from vitae group by peopleId,seq  having count(*) > 1)

4��ɾ�����ж�����ظ���¼������ֶΣ���ֻ����rowid��С�ļ�¼
delete from vitae a
where (a.peopleId,a.seq) in  (select peopleId,seq from vitae group by peopleId,seq having count(*) > 1)
and rowid not in (select min(rowid) from vitae group by peopleId,seq having count(*)>1)


5�����ұ��ж�����ظ���¼������ֶΣ���������rowid��С�ļ�¼
select * from vitae a
where (a.peopleId,a.seq) in  (select peopleId,seq from vitae group by peopleId,seq having count(*) > 1)
and rowid not in (select min(rowid) from vitae group by peopleId,seq having count(*)>1)

(��)
�ȷ�˵
��A���д���һ���ֶΡ�name����
���Ҳ�ͬ��¼֮��ġ�name��ֵ�п��ܻ���ͬ��
���ھ�����Ҫ��ѯ���ڸñ��еĸ���¼֮�䣬��name��ֵ�����ظ����
Select Name,Count(*) From A Group By Name Having Count(*) > 1

��������Ա�Ҳ��ͬ��������:
Select Name,sex,Count(*) From A Group By Name,sex Having Count(*) > 1


(��)
����һ

declare @max integer,@id integer

declare cur_rows cursor local for select ���ֶ�,count(*) from ���� group by ���ֶ� having count(*) >�� 1

open cur_rows

fetch cur_rows into @id,@max

while @@fetch_status=0

begin

select @max = @max -1

set rowcount @max

delete from ���� where ���ֶ� = @id

fetch cur_rows into @id,@max

end

close cur_rows

set rowcount 0

������

���������������ϵ��ظ���¼��һ����ȫ�ظ��ļ�¼��Ҳ�������ֶξ��ظ��ļ�¼�����ǲ��ֹؼ��ֶ��ظ��ļ�¼������Name�ֶ��ظ����������ֶβ�һ���ظ����ظ����Ժ��ԡ�

1�����ڵ�һ���ظ����Ƚ����׽����ʹ��

select distinct * from tableName

�Ϳ��Եõ����ظ���¼�Ľ������

����ñ���Ҫɾ���ظ��ļ�¼���ظ���¼����1���������԰����·���ɾ��

select distinct * into #Tmp from tableName

drop table tableName

select * into tableName from #Tmp

drop table #Tmp

���������ظ���ԭ���Ǳ���Ʋ��ܲ����ģ�����Ψһ�����м��ɽ����

2�������ظ�����ͨ��Ҫ�����ظ���¼�еĵ�һ����¼��������������

�������ظ����ֶ�ΪName,Address��Ҫ��õ��������ֶ�Ψһ�Ľ����

select identity(int,1,1) as autoID, * into #Tmp from tableName

select min(autoID) as autoID into #Tmp2 from #Tmp group by Name,autoID

select * from #Tmp where autoID in(select autoID from #tmp2)

���һ��select���õ���Name��Address���ظ��Ľ������������һ��autoID�ֶΣ�ʵ��дʱ����д��select�Ӿ���ʡȥ���У�

(��)

��ѯ�ظ�

select * from tablename where id in (

select id from tablename 

group by id 

having count(id) > 1

)