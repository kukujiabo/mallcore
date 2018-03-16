CREATE VIEW `v_member_union_data` AS 
SELECT 
a.*, 
b.member_name, 
b.member_level,
c.point,
c.balance,
c.pos_id,
c.card_id
FROM `user` a, `member` b, `member_account` c
where a.uid = b.uid and a.uid = c.uid;
