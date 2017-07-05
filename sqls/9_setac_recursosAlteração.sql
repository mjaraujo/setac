ALTER TABLE `setac`.`recursos` 
CHANGE COLUMN `rec_descricao` `rec_descricao` VARCHAR(255) NOT NULL COMMENT '' ,
CHANGE COLUMN `rec_timestamp` `rec_timestamp` TIMESTAMP NOT NULL COMMENT '' ,
ADD COLUMN `rec_num_patrimonio` VARCHAR(45) NOT NULL COMMENT '' AFTER `rec_id`;
