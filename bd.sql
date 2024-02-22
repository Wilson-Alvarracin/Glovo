CREATE DATABASE IF NOT EXISTS db_glovo;

USE db_glovo;

-- Crear tabla `tbl_cocinas`
CREATE TABLE IF NOT EXISTS `tbl_cocinas` (
  `id_cocina` int NOT NULL AUTO_INCREMENT,
  `cocina_nom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_cocina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Crear tabla `tbl_usr`
CREATE TABLE IF NOT EXISTS `tbl_usr` (
  `id_usr` int NOT NULL AUTO_INCREMENT,
  `usr_nom` varchar(45) DEFAULT NULL,
  `usr_ape` varchar(45) DEFAULT NULL,
  `usr_email` varchar(45) DEFAULT NULL,
  `usr_pwd` varchar(45) DEFAULT NULL,
  `usr_rol` enum('admin','user','gerente') DEFAULT NULL,
  PRIMARY KEY (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- Crear tabla `tbl_restaurante`
CREATE TABLE IF NOT EXISTS `tbl_restaurante` (
  `id_restaurante` int NOT NULL AUTO_INCREMENT,
  `rest_nom` varchar(45) DEFAULT NULL,
  `rest_desc` varchar(45) DEFAULT NULL,
  `id_usr_gerente` int NOT NULL,
  `rest_header` varchar(255) DEFAULT NULL,
  `rest_logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_restaurante`),
  KEY `fk_tbl_restaurante_tbl_usr1_idx` (`id_usr_gerente`),
  CONSTRAINT `fk_tbl_restaurante_tbl_usr1` FOREIGN KEY (`id_usr_gerente`) REFERENCES `tbl_usr` (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Crear tabla `tbl_platos`
CREATE TABLE IF NOT EXISTS `tbl_platos` (
  `id_plato` int NOT NULL AUTO_INCREMENT,
  `plato_precio` int DEFAULT NULL,
  `plato_descripcion` varchar(45) DEFAULT NULL,
  `id_restaurante` int NOT NULL,
  `plato_imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_plato`),
  KEY `fk_tbl_platos_tbl_restaurante1_idx` (`id_restaurante`),
  CONSTRAINT `fk_tbl_platos_tbl_restaurante1` FOREIGN KEY (`id_restaurante`) REFERENCES `tbl_restaurante` (`id_restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- Crear tabla `tbl_restu_cocina`
CREATE TABLE IF NOT EXISTS `tbl_restu_cocina` (
  `id_tip_cocina` int NOT NULL AUTO_INCREMENT,
  `id_restaurante` int NOT NULL,
  `tipo_cocina` int NOT NULL,
  PRIMARY KEY (`id_tip_cocina`),
  KEY `fk_tbl_restu_cocina_tbl_restaurante1_idx` (`id_restaurante`),
  KEY `fk_tbl_restu_cocina_tbl_Cocinas1_idx` (`tipo_cocina`),
  CONSTRAINT `fk_tbl_restu_cocina_tbl_Cocinas1` FOREIGN KEY (`tipo_cocina`) REFERENCES `tbl_cocinas` (`id_cocina`),
  CONSTRAINT `fk_tbl_restu_cocina_tbl_restaurante1` FOREIGN KEY (`id_restaurante`) REFERENCES `tbl_restaurante` (`id_restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Crear tabla `tbl_valoracion`
CREATE TABLE IF NOT EXISTS `tbl_valoracion` (
  `id_valoracion` int NOT NULL AUTO_INCREMENT,
  `id_rest` int NOT NULL,
  `valoracion` DECIMAL(3,2) DEFAULT NULL,
  `comentario` varchar(45) DEFAULT NULL,
  `id_usr` int NOT NULL,
  PRIMARY KEY (`id_valoracion`),
  KEY `fk_tbl_valoracion_tbl_restaurante_idx` (`id_rest`),
  KEY `fk_tbl_valoracion_tbl_usr1_idx` (`id_usr`),
  CONSTRAINT `fk_tbl_valoracion_tbl_restaurante` FOREIGN KEY (`id_rest`) REFERENCES `tbl_restaurante` (`id_restaurante`),
  CONSTRAINT `fk_tbl_valoracion_tbl_usr1` FOREIGN KEY (`id_usr`) REFERENCES `tbl_usr` (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;