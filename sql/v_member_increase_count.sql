CREATE VIEW `v_member_increase_by_date` AS
select 
count(1) num,
reg_date
from lumeijia.user 
where user_tel is not null and is_member = 1
group by reg_date
