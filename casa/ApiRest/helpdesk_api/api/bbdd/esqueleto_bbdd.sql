DROP DATABASE IF EXISTS helpdesk_api;
CREATE DATABASE helpdesk_api
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE helpdesk_api;

-- =========================
-- 0) API KEYS (igual que en tu ejercicio anterior)
-- =========================
CREATE TABLE api_keys (
  key_hash   CHAR(64) PRIMARY KEY,           -- SHA-256 (hex)
  rol        ENUM('usuario','admin') NOT NULL,
  activa     TINYINT(1) NOT NULL DEFAULT 1,
  creada_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- 1) PROYECTOS
-- =========================
CREATE TABLE proyectos (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(120) NOT NULL,
  cliente    VARCHAR(120) NOT NULL,
  activo     TINYINT(1) NOT NULL DEFAULT 1,
  creado_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- 2) TICKETS (incidencias)
-- =========================
CREATE TABLE tickets (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  proyecto_id     INT UNSIGNED NOT NULL,

  titulo          VARCHAR(160) NOT NULL,
  descripcion     TEXT NOT NULL,

  prioridad       ENUM('baja','media','alta','critica') NOT NULL DEFAULT 'media',
  estado          ENUM('abierto','en_progreso','resuelto','cerrado') NOT NULL DEFAULT 'abierto',

  creado_por      VARCHAR(120) NOT NULL,          -- email/nombre (simple)
  asignado_a      VARCHAR(120) NULL,              -- email/nombre (simple)

  fecha_apertura  DATE NOT NULL,
  fecha_cierre    DATE NULL,

  creado_en       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en  DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_tickets_proyecto
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,

  INDEX idx_tickets_proyecto (proyecto_id),
  INDEX idx_tickets_estado (estado),
  INDEX idx_tickets_prioridad (prioridad),
  INDEX idx_tickets_fecha (fecha_apertura)
) ENGINE=InnoDB;

-- =========================
-- 3) COMENTARIOS (para practicar 1:N)
-- =========================
CREATE TABLE comentarios (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_id  INT UNSIGNED NOT NULL,
  autor      VARCHAR(120) NOT NULL,
  mensaje    VARCHAR(500) NOT NULL,
  creado_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_comentarios_ticket
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
    ON DELETE CASCADE ON UPDATE CASCADE,

  INDEX idx_comentarios_ticket (ticket_id)
) ENGINE=InnoDB;