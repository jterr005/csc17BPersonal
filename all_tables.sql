-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema final_project
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema final_project
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `final_project` DEFAULT CHARACTER SET latin1 ;
USE `final_project` ;

-- -----------------------------------------------------
-- Table `final_project`.`cart_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`cart_users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(15) NOT NULL,
  `last_name` VARCHAR(15) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `pass` LONGTEXT NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_company` (
  `company_id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(45) NOT NULL,
  `origin_country` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE INDEX `company_name_UNIQUE` (`company_name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_order_contents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_order_contents` (
  `order_contents_id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `smartphone_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `price` DECIMAL(25,2) NOT NULL,
  PRIMARY KEY (`order_contents_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NOT NULL,
  `total` DECIMAL(25,2) NOT NULL,
  PRIMARY KEY (`order_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_responses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_responses` (
  `reponse_id` INT(11) NOT NULL AUTO_INCREMENT,
  `survey_id` INT(11) NOT NULL,
  `answer_one` VARCHAR(280) NOT NULL,
  `answer_two` VARCHAR(280) NOT NULL,
  `answer_three` VARCHAR(280) NOT NULL,
  PRIMARY KEY (`reponse_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_smartphone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_smartphone` (
  `smartphone_id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `phone_name` VARCHAR(40) NOT NULL,
  `price` INT(11) NOT NULL,
  `memory` INT(11) NOT NULL,
  `description` VARCHAR(280) NOT NULL,
  `image_name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`smartphone_id`),
  UNIQUE INDEX `phone_name_UNIQUE` (`phone_name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_survey`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_survey` (
  `survey_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `survey_name` VARCHAR(45) NOT NULL,
  `question_one` VARCHAR(280) NOT NULL,
  `question_two` VARCHAR(280) NOT NULL,
  `question_three` VARCHAR(280) NOT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE INDEX `survey_name_UNIQUE` (`survey_name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `final_project`.`entity_survey_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `final_project`.`entity_survey_users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(15) NOT NULL,
  `last_name` VARCHAR(15) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `pass` LONGTEXT NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
