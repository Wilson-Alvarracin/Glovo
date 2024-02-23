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
  CONSTRAINT `fk_tbl_platos_tbl_restaurante1` FOREIGN KEY (`id_restaurante`) REFERENCES `tbl_restaurante` (`id_restaurante`) ON DELETE CASCADE
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
  `plato_nombre` varchar(45) DEFAULT NULL,
  `plato_descripcion` varchar(255) DEFAULT NULL,
  `id_restaurante` int NOT NULL,
  `plato_imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_plato`),
  KEY `fk_tbl_platos_tbl_restaurante1_idx` (`id_restaurante`),
  CONSTRAINT `fk_tbl_platos_tbl_restaurante1` FOREIGN KEY (`id_restaurante`) REFERENCES `tbl_restaurante` (`id_restaurante`) ON DELETE CASCADE
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

















-- Insertar tipos de cocina
INSERT INTO `tbl_cocinas` (`cocina_nom`) VALUES
('Italiana'),
('Mexicana'),
('Japonesa'),
('Mediterránea'),
('Americana'),
('China'),
('India'),
('Francesa'),
('Vietnamita'),
('Coreana'),
('Española'),
('Tailandesa'),
('Griega'),
('Turca'),
('Brasileña'),
('Argentina'),
('Peruana'),
('Marroquí'),
('Sudafricana');

-- Insertar usuarios
INSERT INTO `tbl_usr` (`id_usr`, `usr_nom`, `usr_ape`, `usr_email`, `usr_pwd`, `usr_rol`) VALUES
(1, 'Juan', 'Pérez', 'juan@example.com', 'password', 'user'),
(2, 'María', 'González', 'maria@example.com', 'password', 'user'),
(3, 'Pedro', 'Martínez', 'pedro@example.com', 'password', 'gerente'),
(4, 'Laura', 'López', 'laura@example.com', 'password', 'user'),
(5, 'Carlos', 'Rodríguez', 'carlos@example.com', 'password', 'user'),
(6, 'Ana', 'Sánchez', 'ana@example.com', 'password', 'gerente'),
(7, 'David', 'Gómez', 'david@example.com', 'password', 'admin'),
(8, 'Elena', 'Martínez', 'elena@example.com', 'password', 'gerente'),
(9, 'Andrea', 'García', 'andrea@example.com', 'password', 'user'),
(10, 'Javier', 'Ruiz', 'javier@example.com', 'password', 'user'),
(11, 'Patricia', 'Fernández', 'patricia@example.com', 'password', 'gerente'),
(12, 'Sergio', 'Díaz', 'sergio@example.com', 'password', 'admin'),
(13, 'Carmen', 'López', 'carmen@example.com', 'password', 'gerente'),
(14, 'Mario', 'Sánchez', 'mario@example.com', 'password', 'user'),
(15, 'Sofía', 'Martínez', 'sofia@example.com', 'password', 'user'),
(16, 'Diego', 'Hernández', 'diego@example.com', 'password', 'gerente'),
(17, 'Lucía', 'Gómez', 'lucia@example.com', 'password', 'user'),
(18, 'Manuel', 'Torres', 'manuel@example.com', 'password', 'user');

-- Insertar restaurantes
INSERT INTO `tbl_restaurante` (`rest_nom`, `rest_desc`, `id_usr_gerente`) VALUES
('Pizzería Italia', 'Auténtica pizza italiana', 3),
('Taquería Jalisco', 'Deliciosos tacos mexicanos', 3),
('Sushi Bar Kyoto', 'Sushi fresco y auténtico', 3),
('Burger Joint', 'Hamburguesas gourmet', 6),
('Golden Dragon', 'Auténtica comida china', 8),
('Taj Mahal', 'Especialidades indias', 6),
('La Brasserie', 'Comida francesa sofisticada', 8),
('Pho Vietnam', 'Sopa vietnamita tradicional', 6),
('Seoul Kitchen', 'Platos coreanos tradicionales', 11),
('La Tasca', 'Tapas españolas auténticas', 13),
('Thai Palace', 'Comida tailandesa picante', 16),
('Olive Tree', 'Cocina griega mediterránea', 11),
('Istanbul Grill', 'Kebabs y mezze turcos', 17),
('Brazilian Grill', 'Carnes asadas brasileñas', 14),
('La Parrilla', 'Auténtica parrillada argentina', 15),
('El Ceviche', 'Sabores peruanos frescos', 18),
('Café Marrakech', 'Especialidades marroquíes', 13),
('Safari Grill', 'Carnes a la parrilla sudafricanas', 16);

-- Insertar relación entre restaurantes y tipos de cocina
INSERT INTO `tbl_restu_cocina` (`id_restaurante`, `tipo_cocina`) VALUES
(1, 1), -- Pizzería Italia (Italiana)
(2, 2), -- Taquería Jalisco (Mexicana)
(3, 3), -- Sushi Bar Kyoto (Japonesa)
(4, 5), -- Burger Joint (Americana)
(5, 6), -- Golden Dragon (China)
(6, 7), -- Taj Mahal (India)
(7, 8), -- La Brasserie (Francesa)
(8, 9), -- Pho Vietnam (Vietnamita)
(9, 10), -- Seoul Kitchen (Coreana)
(10, 11), -- La Tasca (Española)
(11, 12), -- Thai Palace (Tailandesa)
(12, 13), -- Olive Tree (Griega)
(13, 14), -- Istanbul Grill (Turca)
(14, 15), -- Brazilian Grill (Brasileña)
(15, 16), -- La Parrilla (Argentina)
(16, 17), -- El Ceviche (Peruana)
(17, 18), -- Café Marrakech (Marroquí)
(18, 19); -- Safari Grill (Sudafricana)

INSERT INTO `tbl_platos` (`plato_precio`, `plato_nombre`, `plato_descripcion`, `id_restaurante`) VALUES
(10, 'Pizza Margarita', 'Pizza Margarita italiana con salsa de tomate, mozzarella y albahaca fresca', 1), -- Pizzería Italia
(12, 'Taco al pastor', 'Tortilla de maíz con carne de cerdo adobada, cebolla, cilantro y piña', 2), -- Taquería Jalisco
(20, 'Sashimi de salmón', 'Finas láminas de salmón crudo con salsa de soja y wasabi', 3), -- Sushi Bar Kyoto
(15, 'Cheeseburger con bacon', 'Hamburguesa de carne con queso cheddar, tocino y aderezos', 4), -- Burger Joint
(18, 'Pato a la pekinesa', 'Pato asado con salsa hoisin y cebolla verde', 5), -- Golden Dragon
(14, 'Curry de pollo', 'Pollo cocido en salsa de curry con especias', 6), -- Taj Mahal
(25, 'Foie gras con pan tostado', 'Foie gras a la plancha con pan tostado', 7), -- La Brasserie
(10, 'Pho de ternera', 'Sopa vietnamita de fideos con ternera y hierbas', 8), -- Pho Vietnam
(22, 'Bulgogi', 'Carne de res marinada y asada con arroz y kimchi', 9), -- Seoul Kitchen
(16, 'Tortilla española', 'Tortilla de patatas con cebolla y huevos', 10), -- La Tasca
(20, 'Pad Thai', 'Fideos de arroz con camarones, tofu, cacahuetes y salsa de tamarindo', 11), -- Thai Palace
(18, 'Moussaka', 'Berenjenas, carne picada, tomate y bechamel gratinados', 12), -- Olive Tree
(25, 'Doner kebab', 'Carne de cordero asada en pan de pita con verduras y salsa de yogur', 13), -- Istanbul Grill
(30, 'Picanha', 'Corte de carne brasileño servido con arroz, frijoles y farofa', 14), -- Brazilian Grill
(28, 'Asado argentino', 'Selección de carnes asadas con chimichurri y papas fritas', 15), -- La Parrilla
(15, 'Ceviche mixto', 'Pescado y mariscos marinados en limón con cebolla y cilantro', 16), -- El Ceviche
(18, 'Tagine de cordero', 'Cordero estofado con ciruelas, almendras y especias', 17), -- Café Marrakech
(35, 'Braai', 'Barbacoa sudafricana de carne asada a la parrilla', 18); -- Safari Grill

-- Insertar valoraciones
INSERT INTO `tbl_valoracion` (`id_rest`, `valoracion`, `comentario`, `id_usr`) VALUES
(1, 5, 'Excelente pizza, volveré pronto', 1), -- Pizzería Italia
(2, 4, 'Los tacos estaban muy sabrosos', 2), -- Taquería Jalisco
(3, 5, 'El sushi fresco y bien presentado', 3), -- Sushi Bar Kyoto
(4, 4, 'Las hamburguesas estaban deliciosas', 4), -- Burger Joint
(5, 5, 'Comida china auténtica y deliciosa', 5), -- Golden Dragon
(6, 4, 'Sabores exóticos y bien preparados', 6), -- Taj Mahal
(7, 5, 'Experiencia culinaria excepcional', 7), -- La Brasserie
(8, 4, 'La sopa vietnamita muy reconfortante', 8), -- Pho Vietnam
(9, 4, 'La comida coreana estaba deliciosa', 9), -- Seoul Kitchen
(10, 5, 'Tapas españolas de alta calidad', 10), -- La Tasca
(11, 4, 'Comida tailandesa auténtica y sabrosa', 11), -- Thai Palace
(12, 5, 'Excelente moussaka, muy recomendado', 12), -- Olive Tree
(13, 4, 'Kebabs turcos deliciosos y auténticos', 13), -- Istanbul Grill
(14, 5, 'Las carnes asadas brasileñas son increíbles', 14), -- Brazilian Grill
(15, 4, 'Auténtico asado argentino, gran experiencia', 15), -- La Parrilla
(16, 5, 'El ceviche estaba fresco y bien sazonado', 16), -- El Ceviche
(17, 4, 'Sabores marroquíes auténticos y deliciosos', 17), -- Café Marrakech
(18, 5, 'El braai sudafricano es una delicia', 18); -- Safari Grill