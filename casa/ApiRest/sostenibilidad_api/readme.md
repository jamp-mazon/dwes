# Ejercicio PHP — API REST CRUD (MySQL) “Mediciones Energéticas”

## Objetivo
Construir una **API REST en PHP (sin framework)** que implemente un **CRUD** sobre una tabla MySQL llamada `mediciones`, devolviendo **siempre JSON** y usando correctamente los **códigos HTTP**.

---

## Base de datos
- Crear la BBDD `sostenibilidad_api`.
- Crear la tabla `mediciones` con estos campos:
  - `id` (PK autoincremental)
  - `ubicacion` (VARCHAR, obligatorio)
  - `fecha` (DATE, obligatorio)
  - `kwh` (DECIMAL, obligatorio)
  - `fuente` (ENUM: red | solar | mixta, obligatorio)
  - `observaciones` (VARCHAR, opcional)
  - `creado_en`, `actualizado_en`
- Restricción: `UNIQUE (ubicacion, fecha)` para evitar duplicados del mismo día en la misma ubicación.
- Insertar datos de prueba (inserts) para poder testear endpoints.

---

## Requisitos generales de la API
- Responder **siempre en JSON**.
- Añadir cabecera:
  - `Content-Type: application/json; charset=utf-8`
- Manejar rutas con un “front controller”:
  - `public/index.php` recibe todo
  - detecta método HTTP + ruta
  - llama al controlador correspondiente
- Acceso a BBDD con **PDO** y **consultas preparadas** (sin concatenar SQL).
- Validar entrada y devolver errores claros.

---

## Endpoints obligatorios (CRUD)

### 1) Listado con filtros
**GET** `/api/mediciones`

Debe:
- devolver un array de mediciones.
- permitir filtros opcionales por querystring:
  - `ubicacion=Casa`
  - `fuente=solar`
  - `desde=YYYY-MM-DD`
  - `hasta=YYYY-MM-DD`
- (Opcional) paginación: `limit` y `offset`
- (Opcional) orden: `sort=fecha` y `order=asc|desc`

---

### 2) Obtener por id
**GET** `/api/mediciones/{id}`

Debe:
- devolver la medición concreta.
- si no existe: **404 Not Found**.

---

### 3) Crear medición
**POST** `/api/mediciones`

Body **JSON** (ejemplo):
```json
{
  "ubicacion": "Casa",
  "fecha": "2026-01-10",
  "kwh": 8.75,
  "fuente": "red",
  "observaciones": "Día de lluvia"
}
```
---
### 4) Seguridad: API Keys con roles

### Tabla `api_keys`
La API usará autenticación por **API Key**. Cada clave tendrá un **rol** (`usuario` o `admin`) y un estado (`activa`).

Campos de la tabla:
- `key_hash` (PRIMARY KEY) → hash **SHA-256** en hexadecimal (64 caracteres)
- `rol` → `usuario` | `admin`
- `activa` → 0/1
- `creada_en` → fecha de creación

Restricciones:
- **No se guarda la key en texto plano**, solo su `key_hash`.
- La API Key enviada por el cliente se valida calculando su **SHA-256** y comparándolo con `key_hash`.

SQL de la tabla:
```sql
CREATE TABLE api_keys (
  key_hash   CHAR(64) PRIMARY KEY,
  rol        ENUM('usuario','admin') NOT NULL,
  activa     TINYINT(1) NOT NULL DEFAULT 1,
  creada_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

```
INSERT de claves en la tabla:
```sql
INSERT INTO api_keys (key_hash, rol, activa) VALUES
(SHA2('1234', 256), 'usuario', 1),
(SHA2('123456', 256), 'admin', 1);