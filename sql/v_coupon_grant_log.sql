CREATE VIEW `v_coupon_grant_union_info` AS
SELECT
a.*,
b.member_name,
c.coupon_name,
d.user_tel as mobile,
e.use_time,
e.state
FROM
coupon_grant_log a,
member b,
coupon_type c,
`user` d,
coupon e
where 
a.uid = b.uid and
a.uid = d.uid and
a.coupon_type_id = c.coupon_type_id and
a.coupon_code = e.coupon_code
