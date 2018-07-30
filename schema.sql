CREATE TABLE IF NOT EXISTS `mydb`.`cp_tb_user` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'userid',
  `username` VARCHAR(45) NULL DEFAULT NULL COMMENT 'username',
  `password` VARCHAR(45) NULL DEFAULT NULL COMMENT 'password',
  `fullname` VARCHAR(45) NULL DEFAULT NULL COMMENT 'ull name',
  `email` VARCHAR(45) NULL DEFAULT NULL COMMENT 'email',
  `contact_no` INT(11) NULL DEFAULT NULL COMMENT 'phone number',
  `is_blocked` TINYINT(1) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL,
  `receving_email` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 104
DEFAULT CHARACTER SET = utf8;