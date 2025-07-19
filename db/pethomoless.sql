
DROP SCHEMA IF EXISTS pethomeless;
DROP USER IF EXISTS 'homeless'@'%';


CREATE USER 'homeless'@'%' IDENTIFIED BY 'homeless_pass';
CREATE DATABASE IF NOT EXISTS pethomeless CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON pethomeless.* TO 'homeless'@'%';
USE pethomeless;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  rol ENUM('usuario','admin') NOT NULL DEFAULT 'usuario',
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS animales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  raza VARCHAR(100) DEFAULT NULL,
  color VARCHAR(50) DEFAULT NULL,
  tamanio ENUM('pequeño','mediano','grande') DEFAULT NULL,
  fecha_encontrado DATE NOT NULL,
  lugar VARCHAR(150) DEFAULT NULL,
  foto VARCHAR(255) DEFAULT NULL,
  reclamado TINYINT(1) NOT NULL DEFAULT 0,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS resena;
CREATE TABLE resena (
    id INT AUTO_INCREMENT PRIMARY KEY,
    autor VARCHAR(50) NOT NULL,
    contenido VARCHAR(500) NOT NULL,
    calificacion INT NOT NULL CHECK (calificacion BETWEEN 1 AND 5),
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO resena (autor, contenido, calificacion, fecha) VALUES
('María Pérez', 'Gracias por encontrar a mi mascota', 5, NOW()),
('Juan López', 'La mejor pagina', 4, NOW() - INTERVAL 1 DAY),
('Ana Sánchez', 'Gracias a esta pagina le hemos buscando hogar a 2 mascotas', 5, NOW() - INTERVAL 2 DAY);


CREATE TABLE IF NOT EXISTS adopciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  animal_id INT NOT NULL,
  fecha_adopcion DATE NOT NULL,
  adoptante_nombre VARCHAR(100) NOT NULL,
  adoptante_contacto VARCHAR(100) NOT NULL,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (animal_id) REFERENCES animales(id) ON DELETE CASCADE
) ENGINE=InnoDB;


INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES
('Admin','admin@homeless.cr',SHA2('admin123',256),'admin'),
('Usuario1','user@gmail.com',SHA2('user123',256),'usuario');


INSERT INTO animales (usuario_id, tipo, raza, color, tamanio, fecha_encontrado, lugar, foto) VALUES
(1,'Perro','Mestizo','Café','mediano','2025-07-01','San José','https://cdn0.expertoanimal.com/es/posts/3/3/2/braco_aleman_de_pelo_corto_26233_5_600.jpg'),
(2,'Gato','Siamés','Blanco y gris','pequeño','2025-06-28','Heredia','https://upload.wikimedia.org/wikipedia/commons/6/60/Neighbours_Siamese.jpg'),
(2,'Conejo','Lop','Blanco','pequeño','2025-07-02','Alajuela','https://www.mundoconejos.com/wp-content/uploads/2018/04/conejito-blanco-de-florida-830x830.jpeg');



INSERT INTO adopciones (animal_id, fecha_adopcion, adoptante_nombre, adoptante_contacto) VALUES
(1,'2025-07-10','Familia López','+506 8765-4321');



select * from usuarios;


select * from resena;