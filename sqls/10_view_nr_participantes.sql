CREATE ALGORITHM=UNDEFINED DEFINER='root'@'localhost' SQL SECURITY DEFINER VIEW `nr_participantes`
AS
select
  count(0) AS `quantidade`
from
  ((((`participantes` `par`
  left join `usuarios` `usu` on ((`usu`.`par_id` = `par`.`par_id`)))
  left join `enderecos` `end` on ((`end`.`par_id` = `par`.`par_id`)))
  left join `logradouros` `log` on ((`log`.`log_id` = `end`.`log_id`)))
  left join `cidades` `cid` on ((`cid`.`cid_id` = `log`.`cid_id`)));