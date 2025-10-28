<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio · MiniCine</title>
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

<section class="hero">
  <div>
    <h1>Bienvenido a MiniCine</h1>
    <p>Plantilla base con HTML y CSS para que te centres en PHP: formularios sticky, cookies, sesiones y persistencia en JSON.</p>
    <div class="btns">
      <a class="btn btn-primary" href="login.php">Entrar</a>
      <a class="btn btn-outline" href="register.php">Crear cuenta</a>
      <a class="btn btn-outline" href="cartelera.php">Ver cartelera</a>
    </div>
  </div>
  <div class="card">
    <div class="media"></div>
    <div class="body">
      <h3>Cómo usar esta plantilla</h3>
      <p class="small">Sustituye los contenidos de ejemplo por bucles y echos PHP. Inserta tokens CSRF, gestiona sesiones y lee datos JSON.</p>
      <div class="alert"><strong>Pista:</strong> Usa el patrón PRG tras los POST.</div>
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
