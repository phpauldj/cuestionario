SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `dbencuesta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `dbencuesta`;

-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

CREATE  TABLE IF NOT EXISTS `usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user` VARCHAR(30) NOT NULL ,
  `pass` VARCHAR(15) NOT NULL ,
  `rol` ENUM('admin','usuario') NOT NULL DEFAULT 'usuario' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `especialidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `especialidad` ;

CREATE  TABLE IF NOT EXISTS `especialidad` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cargo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cargo` ;

CREATE  TABLE IF NOT EXISTS `cargo` (
  `id` INT NOT NULL ,
  `name` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estado_civil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estado_civil` ;

CREATE  TABLE IF NOT EXISTS `estado_civil` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grado_instruccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grado_instruccion` ;

CREATE  TABLE IF NOT EXISTS `grado_instruccion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(60) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ficha_sociodemo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ficha_sociodemo` ;

CREATE  TABLE IF NOT EXISTS `ficha_sociodemo` (
  `usuario_id` INT NOT NULL ,
  `edad` TINYINT(2) NULL ,
  `sexo` TINYINT(1) NULL ,
  `especialidad_id` INT NULL ,
  `grado_instruccion_id` INT NULL ,
  `cargo_id` INT NULL ,
  `estado_civil_id` INT NULL ,
  `tipo_contrata` VARCHAR(1) NULL ,
  INDEX `fk_ficha_sociodemo_especialidad` (`especialidad_id` ASC) ,
  INDEX `fk_ficha_sociodemo_grado_instruccion1` (`grado_instruccion_id` ASC) ,
  INDEX `fk_ficha_sociodemo_cargo1` (`cargo_id` ASC) ,
  INDEX `fk_ficha_sociodemo_estado_civil1` (`estado_civil_id` ASC) ,
  PRIMARY KEY (`usuario_id`) ,
  INDEX `fk_ficha_sociodemo_usuario1` (`usuario_id` ASC) ,
  CONSTRAINT `fk_ficha_sociodemo_especialidad`
    FOREIGN KEY (`especialidad_id` )
    REFERENCES `especialidad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_sociodemo_grado_instruccion1`
    FOREIGN KEY (`grado_instruccion_id` )
    REFERENCES `grado_instruccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_sociodemo_cargo1`
    FOREIGN KEY (`cargo_id` )
    REFERENCES `cargo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_sociodemo_estado_civil1`
    FOREIGN KEY (`estado_civil_id` )
    REFERENCES `estado_civil` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_sociodemo_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `encuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `encuesta` ;

CREATE  TABLE IF NOT EXISTS `encuesta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(150) NOT NULL ,
  `descrip` VARCHAR(250) NULL ,
  `fecini` DATETIME NOT NULL ,
  `fecfin` DATETIME NOT NULL ,
  `activo` TINYINT(1) NOT NULL DEFAULT 1 ,
  `usuario_id` INT NOT NULL COMMENT 'quien registro la encuesta' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_encuesta_usuario1` (`usuario_id` ASC) ,
  CONSTRAINT `fk_encuesta_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pregunta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pregunta` ;

CREATE  TABLE IF NOT EXISTS `pregunta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descrip` VARCHAR(400) NULL ,
  `encuesta_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pregunta_encuesta1` (`encuesta_id` ASC) ,
  CONSTRAINT `fk_pregunta_encuesta1`
    FOREIGN KEY (`encuesta_id` )
    REFERENCES `encuesta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `opcion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `opcion` ;

CREATE  TABLE IF NOT EXISTS `opcion` (
  `id` INT NOT NULL ,
  `name` VARCHAR(100) NULL ,
  `pregunta_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_opcion_pregunta1` (`pregunta_id` ASC) ,
  CONSTRAINT `fk_opcion_pregunta1`
    FOREIGN KEY (`pregunta_id` )
    REFERENCES `pregunta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `respuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `respuesta` ;

CREATE  TABLE IF NOT EXISTS `respuesta` (
  `usuario_id` INT NOT NULL ,
  `opcion_id` INT NOT NULL ,
  `pregunta_id` INT NOT NULL ,
  `change` TINYINT(1) NULL ,
  PRIMARY KEY (`usuario_id`, `opcion_id`) ,
  INDEX `fk_respuesta_usuario1` (`usuario_id` ASC) ,
  INDEX `fk_respuesta_opcion1` (`opcion_id` ASC) ,
  CONSTRAINT `fk_respuesta_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_opcion1`
    FOREIGN KEY (`opcion_id` )
    REFERENCES `opcion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Data for table `estado_civil`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `dbencuesta`;
INSERT INTO `estado_civil` (`id`, `name`) VALUES (1, 'Soltero');
INSERT INTO `estado_civil` (`id`, `name`) VALUES (2, 'Casado');
INSERT INTO `estado_civil` (`id`, `name`) VALUES (3, 'Viudo');
INSERT INTO `estado_civil` (`id`, `name`) VALUES (4, 'Divorciado');
INSERT INTO `estado_civil` (`id`, `name`) VALUES (5, 'Conviviente');

COMMIT;

-- -----------------------------------------------------
-- Data for table `grado_instruccion`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `dbencuesta`;
INSERT INTO `grado_instruccion` (`id`, `name`) VALUES (1, 'Secundaria');
INSERT INTO `grado_instruccion` (`id`, `name`) VALUES (2, 'Técnica');
INSERT INTO `grado_instruccion` (`id`, `name`) VALUES (3, 'Pre-Grado');
INSERT INTO `grado_instruccion` (`id`, `name`) VALUES (4, 'Post-Grado');
INSERT INTO `grado_instruccion` (`id`, `name`) VALUES (5, 'Otro');

COMMIT;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
