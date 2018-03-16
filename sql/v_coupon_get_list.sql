CREATE VIEW `v_coupon_get_list` AS SELECT 
b.member_name,
c.user_tel,
a.*
FROM 
`coupon` a,
`member` b,
`user` c
WHERE
a.uid = b.uid
and a.uid = c.uid
