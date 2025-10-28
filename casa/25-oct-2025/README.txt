
MiniCine – Plantilla HTML/CSS
==============================

Este paquete incluye las páginas y estilos para centrarte en el PHP (sticky, cookies, sesiones, JSON).
Archivos: public/*.php + assets/css/style.css

Qué debes hacer tú
------------------
1) Sustituir tarjetas de ejemplo por loops leyendo `data/peliculas.json`.
2) Implementar validaciones + sticky en login/registro (rellena value con los echos PHP).
3) Generar/validar token CSRF en los formularios (el input hidden ya está listo).
4) Gestionar sesión de usuario y restricción de acceso a reservar/admin.
5) Alta/Borrado de películas + subida de póster a `public/assets/posters/`.
6) Escribir/leer JSON con bloqueo de archivo (LOCK_EX).

Notas
-----
- La UI es responsive y no incluye JS.
- Los asientos de `reservar.php` son A1–A10 y B1–B10 (añade/transforma a dinámica).
- Marca asientos ocupados añadiendo la clase `.disabled` y el atributo `disabled` en el `<input>`.
- Mantén el patrón PRG después de cada POST.

¡Suerte con el examen práctico!
