-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: clock
-- Source Schemata: clock
-- Created: Fri Apr 15 12:59:00 2016
-- Workbench Version: 6.3.6
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema clock
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `clock` ;
CREATE SCHEMA IF NOT EXISTS `clock` ;

-- ----------------------------------------------------------------------------
-- Table clock.admins
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clock`.`admins` (
  `username` VARCHAR(32) NOT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table clock.employees
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clock`.`employees` (
  `ID` INT(11) NULL DEFAULT NULL,
  `Class` TEXT NULL DEFAULT NULL,
  `Name` TEXT NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table clock.logs
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clock`.`logs` (
  `ID` INT(11) NOT NULL,
  `checkedIn` TINYINT(1) NOT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `time` INT(11) NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;
SET FOREIGN_KEY_CHECKS = 1;
