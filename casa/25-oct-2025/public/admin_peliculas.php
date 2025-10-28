<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Películas · MiniCine</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="header">
  <div class="container nav">
    <a class="brand" href="index.php"><span class="dot"></span>MiniCine</a>
    <nav class="navlinks">
      <a href="cartelera.php">Cartelera</a>
      <a href="reservar.php">Reservar</a>
      <a href="admin_peliculas.php"><span class="badge">Admin</span></a>
      <a href="login.php">Entrar</a>
      <a href="register.php">Registro</a>
      <a href="logout.php">Salir</a>
    </nav>
  </div>
</header>
<main class="main"><div class="container">

<h2>Administración de películas</h2>

<section class="grid">
  <form class="form" method="post" action="" enctype="multipart/form-data">
    <h3>Alta de película</h3>
    <div class="alert alert-error" id="admin-errors" style="display:none;">Pinta aquí errores de validación</div>
    <div class="form-row">
      <div class="field">
        <label for="titulo">Título</label>
        <input class="input" type="text" id="titulo" name="titulo" placeholder="Título">
      </div>
      <div class="field">
        <label for="genero">Género</label>
        <select id="genero" name="genero">
          <option>Accion</option><option>Drama</option><option>Comedia</option><option>Terror</option>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="field">
        <label for="duracion_min">Duración (min)</label>
        <input class="input" type="number" id="duracion_min" name="duracion_min" min="1" placeholder="120">
      </div>
      <div class="field">
        <label for="poster">Póster (JPG/PNG máx 1 MB)</label>
        <input class="input" type="file" id="poster" name="poster" accept=".jpg,.jpeg,.png">
      </div>
    </div>
    <input type="hidden" name="csrf_token" value="">
    <div class="btns">
      <button class="btn btn-primary" type="submit" name="accion" value="crear">Crear</button>
    </div>
  </form>

  <div class="card">
    <div class="body">
      <h3>Listado</h3>
      <table class="table">
        <thead><tr><th>ID</th><th>Título</th><th>Género</th><th>Duración</th><th>Póster</th><th>Acciones</th></tr></thead>
        <tbody>
          <!-- Reemplaza por loop PHP -->
          <tr>
            <td>101</td><td>Horizonte Rojo</td><td>Accion</td><td>118</td>
            <td><span class="small">assets/posters/horizonte_rojo.jpg</span></td>
            <td>
              <!-- Borrado protegido con CSRF: usa método POST en producción -->
              <a class="btn btn-danger" href="admin_peliculas.php?delete_id=101&csrf_token=...">Borrar</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

</div></main>
<footer class="footer">
  <div class="container">
    <span>MiniCine · interfaz HTML/CSS — coloca aquí tu lógica PHP (sticky, cookies, sesiones, JSON).</span>
  </div>
</footer>
</body></html>
