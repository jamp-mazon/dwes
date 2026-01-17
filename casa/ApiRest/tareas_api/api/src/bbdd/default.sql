DROP DATABASE IF EXISTS tareas_api;
CREATE DATABASE tareas_api
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tareas_api;

CREATE TABLE api_keys (
  key_hash   CHAR(64) PRIMARY KEY,
  rol        ENUM('usuario','admin') NOT NULL,
  activa     TINYINT(1) NOT NULL DEFAULT 1,
  creada_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO api_keys (key_hash, rol, activa) VALUES
(SHA2('USR_tareas_2026_key_001', 256), 'usuario', 1),
(SHA2('ADM_tareas_2026_key_999', 256), 'admin', 1);

CREATE TABLE tareas (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titulo     VARCHAR(120) NOT NULL,
  completada TINYINT(1) NOT NULL DEFAULT 0,
  creada_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO tareas (titulo, completada) VALUES
('Configurar conexion PDO', 1),
('Leer REQUEST_METHOD y URI', 0),
('Hacer GET /api/tareas', 0),
('Hacer GET /api/tareas/2', 0);