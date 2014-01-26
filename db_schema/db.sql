
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `app` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `app` ;

-- -----------------------------------------------------
-- Table `app`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `app`.`users` (
  `id` INT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NULL,
  `password` VARCHAR(64) NULL,
  `salt` VARCHAR(32) NULL,
  `name` VARCHAR(50) NULL,
  `joined` DATETIME NULL,
  `group` INT(11) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `app`.`group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `app`.`group` (
  `id` INT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NULL,
  `permissions` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `app`.`users_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `app`.`users_sessions` (
  `id` INT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `hash` VARCHAR(50) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `app`.`bookmarks`
-- -----------------------------------------------------
CREATE TABLE `app`.`bookmarks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NULL,
  `url` VARCHAR(128) NULL,
  `created` DATETIME NULL,
  `updated` DATETIME NULL,
  PRIMARY KEY (`id`));
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `app`.`feedss`
-- -----------------------------------------------------
CREATE TABLE `app`.`feeds` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NULL,
  `url` VARCHAR(2083) NULL,
  `created` DATETIME NULL,
  `updated` DATETIME NULL,
  PRIMARY KEY (`id`));
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `app`.`categories`
-- -----------------------------------------------------
CREATE TABLE `app`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `app`.`categories` 
ADD COLUMN `created` DATETIME NULL AFTER `name`,
ADD COLUMN `updated` DATETIME NULL AFTER `created`;

CREATE TABLE `app`.`cat_relations` (
  `cat_id` INT NULL,
  `bookmark_id` INT NULL,
  `feed_id` INT NULL);

ALTER TABLE `app`.`users` 
ADD COLUMN `email` VARCHAR(255) NULL DEFAULT NULL AFTER `group`;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
