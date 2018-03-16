DROP VIEW IF EXISTS `v_action_events`;
CREATE VIEW `v_action_events` 
AS SELECT 
a.action_code as action_code,
a.action_name as action_name,
a.operation as operation,
b.module as module,
b.active as active,
c.event_code as event_code,
c.event_name as event_name,
c.service_name as event_service,
c.method_name as event_method,
c.data as data,
c.validate_start as validate_start,
c.validate_end as validate_end
FROM action a, event_action_relat b, event c
WHERE a.id = b.action_id 
AND b.event_id = c.id
