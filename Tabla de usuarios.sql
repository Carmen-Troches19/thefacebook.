-- SQL para crear la tabla usuarios
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  estatus ENUM('Student', 'Alumnus/alumna', 'Faculty', 'Staff') DEFAULT 'Student' NOT NULL,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) 

