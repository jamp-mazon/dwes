USE sostenibilidad_api;

-- (Opcional) limpia la tabla para repetir pruebas
-- TRUNCATE TABLE mediciones;

INSERT INTO mediciones (ubicacion, fecha, kwh, fuente, observaciones) VALUES
('Casa',    '2026-01-01',  7.80, 'red',   'Día normal'),
('Casa',    '2026-01-02',  8.35, 'red',   'Lavadora + horno'),
('Casa',    '2026-01-03',  6.90, 'mixta', 'Algo de aporte solar'),
('Casa',    '2026-01-04',  9.10, 'red',   'Invitados'),
('Casa',    '2026-01-05',  7.25, 'mixta', 'Buen tiempo'),
('Casa',    '2026-01-06',  6.40, 'solar', 'Placas casi todo el día'),
('Casa',    '2026-01-07',  8.95, 'red',   'Calefacción más fuerte'),
('Casa',    '2026-01-08',  7.05, 'mixta', 'Consumo estable'),
('Casa',    '2026-01-09',  6.70, 'solar', 'Día soleado'),
('Casa',    '2026-01-10',  8.20, 'red',   'Hoy'),

('Oficina', '2026-01-01', 14.50, 'red',   'Arranque de año'),
('Oficina', '2026-01-02', 16.10, 'red',   'Impresoras + reuniones'),
('Oficina', '2026-01-03', 12.80, 'red',   'Sábado (menos actividad)'),
('Oficina', '2026-01-04', 13.40, 'red',   'Domingo (guardia)'),
('Oficina', '2026-01-05', 17.25, 'red',   'Día fuerte'),
('Oficina', '2026-01-06', 11.90, 'red',   'Festivo (mínimo)'),
('Oficina', '2026-01-07', 18.05, 'red',   'Muchos equipos encendidos'),

('Aula 2',  '2026-01-08',  4.60, 'red',   'Clase de tarde'),
('Aula 2',  '2026-01-09',  3.95, 'red',   'Uso puntual'),
('Aula 2',  '2026-01-10',  5.10, 'red',   'Proyector + PCs');
