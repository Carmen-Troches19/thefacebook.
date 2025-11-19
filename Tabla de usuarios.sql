-- tabla usuarios
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(60) NOT NULL,
  estatus ENUM('Estudiante', 'Alumnus/alumna', 'Facultad', 'Colaboradores') DEFAULT 'Estudiante' NOT NULL,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) 

