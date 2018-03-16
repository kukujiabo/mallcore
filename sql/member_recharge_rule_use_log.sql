DROP VIEW IF EXISTS `member_recharge_rule_use_count`;
CREATE VIEW `member_recharge_rule_use_count` AS
select uid, rule_code, count(1) as num
from crm.member_recharge 
group by uid, rule_code;
