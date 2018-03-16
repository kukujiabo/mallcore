DROP VIEW IF EXISTS `v_member_point_rule_use_count`;
CREATE VIEW `v_member_point_rule_use_count` as SELECT uid, rule_id, count(1) as num FROM crm.user_point group by uid, rule_id;

