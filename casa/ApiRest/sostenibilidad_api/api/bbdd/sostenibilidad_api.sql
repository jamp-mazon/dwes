CREATE DATABASE IF NOT EXISTS sostenibilidad_api
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE sostenibilidad_api;

CREATE TABLE mediciones (
  id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ubicacion         VARCHAR(80) NOT NULL,              -- "Casa", "Oficina", "Aula 2"
  fecha             DATE NOT NULL,                     -- yyyy-mm-dd
  kwh               DECIMAL(10,2) NOT NULL,            -- 12.50
  fuente            ENUM('red','solar','mixta') NOT NULL DEFAULT 'red',
  observaciones     VARCHAR(255) NULL,

  creado_en         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en    DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE KEY uq_ubicacion_fecha (ubicacion, fecha)
);
