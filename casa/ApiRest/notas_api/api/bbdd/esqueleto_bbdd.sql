-- =========================================
-- BBDD sencilla para practicar conexión + router
-- Tema: notas rápidas
-- =========================================

DROP DATABASE IF EXISTS notas_api;
CREATE DATABASE notas_api
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE notas_api;

CREATE TABLE notas (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titulo     VARCHAR(120) NOT NULL,
  contenido  VARCHAR(400) NOT NULL,
  creada_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Inserts rápidos
INSERT INTO notas (titulo, contenido) VALUES
('Comprar', 'Arroz, pollo, fruta y agua con limón'),
('PHP API', 'Practicar REQUEST_METHOD y parseo de la URL'),
('Recordatorio', 'Probar GET /api/notas y GET /api/notas/2');
USE notas_api;

-- Tabla API Keys (SHA-256)
CREATE TABLE api_keys (
  key_hash   CHAR(64) PRIMARY KEY,
  rol        ENUM('usuario','admin') NOT NULL,
  activa     TINYINT(1) NOT NULL DEFAULT 1,
  creada_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- API keys en plano (para copiar y pegar):
-- USER:  USR_notas_2026_key_001
-- ADMIN: ADM_notas_2026_key_999

INSERT INTO api_keys (key_hash, rol, activa) VALUES
(SHA2('USR_notas_2026_key_001', 256), 'usuario', 1),
(SHA2('ADM_notas_2026_key_999', 256), 'admin', 1);