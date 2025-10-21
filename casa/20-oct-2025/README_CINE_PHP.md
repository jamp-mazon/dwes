# 🎬 Proyecto CINE PHP

## 📖 Descripción general
Aplicación web en **PHP** que simula el funcionamiento básico de un **cine online**.  
Permite registrar usuarios, iniciar sesión, visualizar una cartelera personalizada según los gustos del usuario, y administrar las películas si el usuario tiene rol de **administrador**.

Los datos se almacenan en formato **JSON** (`usuarios.json` y `peliculas.json`), y se gestionan mediante formularios **sticky** (los datos introducidos permanecen visibles si ocurre un error de validación).

---

## 🏠 1. Página principal: `index.php` (Registro)

### 🧾 Funcionalidad
- Formulario de registro con sticky form.
- Botón **"Ya tengo cuenta"** que redirige a `login.php`.
- Permite especificar si el usuario será **admin** o **usuario normal**.

### 📋 Campos del formulario
- **Nick** (texto)
- **Email** (correo electrónico)
- **Contraseña**
- **Sexo** (radio: Masculino / Femenino / Otro)
- **Categorías de cine favoritas** (checkbox: Acción, Comedia, Drama, Ciencia Ficción, Terror, Animación)
- **Imagen de perfil** (archivo)
- **Rol** (radio: Admin / Usuario)

### 🧠 Comportamiento
- Todos los campos serán validados en el servidor.
- Si hay errores, los datos se conservarán (sticky form) y se mostrarán los mensajes de error.
- Al registrarse correctamente:
  - Se guardará la información en `bbdd/usuarios.json`.
  - La contraseña se almacenará **hasheada**.
  - Se redirigirá al login.

---

## 🔐 2. Inicio de sesión: `login.php`

### 🧾 Funcionalidad
- Formulario sticky de inicio de sesión.
- Permite marcar la casilla **"Recuérdame"**, que creará una **cookie** con el correo del usuario para rellenar el campo automáticamente la próxima vez.
- Si las credenciales son correctas:
  - Se inicia la sesión del usuario.
  - Se redirige a `cartelera.php`.

### 📋 Campos del formulario
- **Email**
- **Contraseña**
- **Recuérdame** (checkbox → crea cookie)
- **Botón de inicio de sesión**

### 🧠 Comportamiento
- Si el usuario es **admin**, al iniciar sesión verá un botón extra en la cartelera para **Administrar cartelera**.
- Si no lo es, accederá a la cartelera normal con las películas que coincidan con sus categorías favoritas.

---

## 🎞️ 3. Cartelera personalizada: `cartelera.php`

### 🧾 Funcionalidad
- Muestra la cartelera personalizada según las categorías elegidas por el usuario al registrarse.
- Muestra en la parte superior:
  - El **nombre** del usuario.
  - Su **imagen de perfil redondeada**.
- Cada película mostrará:
  - Imagen o póster.
  - Título.
  - Categoría.
  - Duración.
  - Sinopsis.
  - Botón **“Acceder”** que lleva a `butacas.php`.

### ⚙️ Comportamiento
- Si el usuario tiene rol **admin**, aparecerá un botón **“Administrar cartelera”** que redirige a `admin_cartelera.php`.
- Los datos de las películas se cargarán desde `bbdd/peliculas.json`.
- Solo se mostrarán las películas que coincidan con las categorías favoritas del usuario.

---

## 🎬 4. Panel de administración: `admin_cartelera.php`

### 🧾 Funcionalidad
- Solo accesible por usuarios con rol **admin**.
- Permite:
  - **Añadir**, **editar** o **eliminar** películas.
  - Subir imagen del póster.
  - Especificar título, duración, categoría y sinopsis.

### 📋 Campos del formulario
- **Imagen o póster**
- **Título**
- **Duración (minutos)**
- **Categoría**
- **Sinopsis (opcional)**

### ⚙️ Comportamiento
- Los datos se guardarán en `bbdd/peliculas.json`.
- Debajo del formulario aparecerá una tabla con todas las películas registradas.
- Cada fila mostrará:
  - Miniatura del póster.
  - Título.
  - Duración.
  - Categoría.
  - Botones **Editar** y **Eliminar**.

---

## 🎟️ 5. Selección de butacas: `butacas.php`

### 🧾 Funcionalidad
- Al hacer clic en una película de la cartelera, se redirige a esta página.
- Muestra una cuadrícula con las butacas disponibles.
- Permite seleccionar múltiples asientos.
- Calcula automáticamente:
  - Número de asientos seleccionados.
  - **Costo total** según el precio por entrada definido.

### ⚙️ Comportamiento
- Al confirmar, mostrará un resumen de la compra (opcional: guardar reserva en JSON).
- El diseño del plano será visual e intuitivo (por ejemplo, filas con letras y columnas con números).

---

## 💾 6. Archivos JSON

### `usuarios.json`
```json
[
  {
    "nick": "JAMP",
    "email": "jamp@example.com",
    "password_hash": "$2y$10$...",
    "sexo": "masculino",
    "categorias": ["accion", "comedia"],
    "avatar": "uploads/jamp.png",
    "esAdmin": "true||false"
  }
]
```

### `peliculas.json`
```json
[
  {
    "id": 1,
    "titulo": "Inception",
    "duracion": 148,
    "categoria": "ciencia_ficcion",
    "sinopsis": "Un ladrón que roba secretos corporativos a través de sueños.",
    "poster": "images/inception.jpg"
  }
]
```

---

## 🧱 7. Estructura del proyecto
```
/cine-app
├─ /bbdd
│  ├─ usuarios.json
│  └─ peliculas.json
├─ /assets
│  ├─ images_user
│  └─ images_pelis
|   
├─ index.php
├─ procesar_index.php
├─ login.php
├─ procesar_login.php
├─ cartelera.php
├─ admin_cartelera.php
├─ butacas.php
└─ estilos.css
```

---

## ✨ 8. Extras
- **Sesiones activas:** Mantienen al usuario logueado.
- **Cookies:** Guardan el correo cuando se marca “Recuérdame”.
- **Sticky forms:** Tanto el formulario de registro como el login conservarán los datos introducidos tras un error.
- **Diseño responsive:** Adaptado a móviles, tablets y pantallas grandes.
- **Validaciones de servidor:** Todos los campos se validarán con PHP antes de guardar.

---

## 🧑‍💻 9. Tecnologías utilizadas
- **PHP 8+**
- **HTML5 / CSS3**
- **JSON (como almacenamiento local)**
- **XAMPP o LAMPP (Apache + PHP)**
- **Visual Studio Code**

---

## 📚 10. Objetivo educativo
Este proyecto está orientado a reforzar el aprendizaje de:
- Manejo de sesiones y cookies en PHP.  
- Validaciones y formularios tipo sticky.  
- Lectura y escritura de archivos JSON.  
- Control de roles (usuario vs admin).  
- Estructuración modular de una aplicación PHP.  
- Gestión visual de datos con HTML y CSS.

---

### 🧩 Autor
**José Antonio Mazón Pérez**  
📅 2025 — Proyecto educativo para el módulo **Desarrollo Web en Entorno Servidor (DWES)**
