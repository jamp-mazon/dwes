<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cartelera · MiniCine</title>
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

<h2>Cartelera</h2>
<form class="filters" method="get" action="">
  <div class="field" style="min-width:220px">
    <label for="q">Buscar título</label>
    <input class="input" type="text" id="q" name="q" placeholder="Ej. Horizonte" value="">
    <!-- Sticky GET: value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" -->
  </div>
  <div class="field" style="min-width:220px">
    <label for="genero">Género</label>
    <select id="genero" name="genero">
      <option value="">Todos</option>
      <option>Accion</option><option>Drama</option><option>Comedia</option><option>Terror</option>
    </select>
    <!-- Sticky GET: selected si coincide con $_GET['genero'] -->
  </div>
  <div>
    <button class="btn btn-primary" type="submit">Filtrar</button>
    <a class="btn btn-outline" href="cartelera.php">Limpiar</a>
  </div>
</form>

<section class="grid grid-3">
  <!-- Sustituye estas tarjetas por un loop PHP con peliculas.json -->
  <article class="card">
    <div class="media"></div>
    <div class="body">
      <h3>Horizonte Rojo</h3>
      <div class="meta">Acción · 118 min</div>
      <div class="btns" style="margin-top:10px">
        <a class="btn btn-primary" href="reservar.php?pelicula_id=101">Reservar</a>
      </div>
    </div>
  </article>
  <article class="card">
    <div class="media"></div>
    <div class="body">
      <h3>Notas de Otoño</h3>
      <div class="meta">Drama · 95 min</div>
      <div class="btns" style="margin-top:10px">
        <a class="btn btn-primary" href="reservar.php?pelicula_id=102">Reservar</a>
      </div>
    </div>
  </article>
  <article class="card">
    <div class="media"></div>
    <div class="body">
      <h3>Risas en Ruta</h3>
      <div class="meta">Comedia · 101 min</div>
      <div class="btns" style="margin-top:10px">
        <a class="btn btn-primary" href="reservar.php?pelicula_id=103">Reservar</a>
      </div>
    </div>
  </article>
</section>

</div></main>
<footer class="footer">
  <div class="container">
    <span>MiniCine · interfaz HTML/CSS — coloca aquí tu lógica PHP (sticky, cookies, sesiones, JSON).</span>
  </div>
</footer>
</body></html>
