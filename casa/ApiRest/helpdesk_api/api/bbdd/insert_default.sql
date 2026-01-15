USE helpdesk_api;

-- API KEYS (en plano para ti):
-- USER:  USR_helpdesk_2026_key_001
-- ADMIN: ADM_helpdesk_2026_key_999
INSERT INTO api_keys (key_hash, rol, activa) VALUES
(SHA2('USR_helpdesk_2026_key_001', 256), 'usuario', 1),
(SHA2('ADM_helpdesk_2026_key_999', 256), 'admin', 1);

-- Proyectos
INSERT INTO proyectos (nombre, cliente, activo) VALUES
('Web corporativa', 'Cafetería Mazón', 1),
('App inventario', 'Taller Norte', 1),
('Intranet RRHH', 'Empresa Demo', 0);

-- Tickets
INSERT INTO tickets
(proyecto_id, titulo, descripcion, prioridad, estado, creado_por, asignado_a, fecha_apertura, fecha_cierre)
VALUES
(1, 'La página de contacto no envía el formulario',
 'Al enviar el formulario sale error 500 y no llega el email.',
 'alta', 'abierto', 'cliente@mazon.com', 'dev1@empresa.com', '2026-01-03', NULL),

(1, 'Texto desbordado en móvil',
 'En pantallas pequeñas el texto se sale del contenedor en la home.',
 'media', 'en_progreso', 'cliente@mazon.com', 'dev2@empresa.com', '2026-01-05', NULL),

(2, 'Login lento en horas punta',
 'Entre 9:00 y 10:00 tarda mucho en autenticar.',
 'critica', 'abierto', 'soporte@tallernorte.es', NULL, '2026-01-07', NULL),

(2, 'Exportación CSV con separador incorrecto',
 'El CSV sale con comas pero lo queremos con punto y coma.',
 'baja', 'resuelto', 'soporte@tallernorte.es', 'dev1@empresa.com', '2026-01-02', '2026-01-04'),

(3, 'Falta el botón de descarga de nóminas',
 'En el panel del empleado no aparece el botón de descarga.',
 'alta', 'cerrado', 'rrhh@demo.com', 'dev3@empresa.com', '2025-12-20', '2025-12-29');

-- Comentarios
INSERT INTO comentarios (ticket_id, autor, mensaje) VALUES
(1, 'dev1@empresa.com', 'Reproducido el fallo. Parece un problema de configuración SMTP.'),
(1, 'cliente@mazon.com', 'Confirmo que empezó después de la última actualización.'),
(2, 'dev2@empresa.com', 'Pendiente ajustar CSS responsive en el contenedor principal.'),
(3, 'soporte@tallernorte.es', 'Esto nos bloquea el trabajo diario, prioridad máxima por favor.'),
(4, 'dev1@empresa.com', 'Arreglado: ahora exporta con ; y codificación UTF-8.');