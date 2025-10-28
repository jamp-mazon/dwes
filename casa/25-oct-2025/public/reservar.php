<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reservar · MiniCine</title>
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

<h2>Reserva de butacas</h2>
<div class="alert" id="pelicula-info">Película seleccionada: <strong><!-- pinta aquí el título desde PHP --></strong></div>

<form class="form" method="post" action="">
  <input type="hidden" name="pelicula_id" value="">
  <!-- Rellena desde $_GET['pelicula_id'] validado -->
  <!-- CSRF -->
  <input type="hidden" name="csrf_token" value="">

  <div class="seats-wrap">
    <div class="screen"></div>
    <div class="seats">
      <!-- Generación estática 2 filas x 10 asientos (A1–A10, B1–B10) como ejemplo -->
      <div class="seat"><input id="A1" type="checkbox" name="butacas[]" value="A1"><label for="A1">A1</label></div>
      <div class="seat"><input id="A2" type="checkbox" name="butacas[]" value="A2"><label for="A2">A2</label></div>
      <div class="seat"><input id="A3" type="checkbox" name="butacas[]" value="A3"><label for="A3">A3</label></div>
      <div class="seat"><input id="A4" type="checkbox" name="butacas[]" value="A4"><label for="A4">A4</label></div>
      <div class="seat"><input id="A5" type="checkbox" name="butacas[]" value="A5"><label for="A5">A5</label></div>
      <div class="seat"><input id="A6" type="checkbox" name="butacas[]" value="A6"><label for="A6">A6</label></div>
      <div class="seat"><input id="A7" type="checkbox" name="butacas[]" value="A7"><label for="A7">A7</label></div>
      <div class="seat"><input id="A8" type="checkbox" name="butacas[]" value="A8"><label for="A8">A8</label></div>
      <div class="seat"><input id="A9" type="checkbox" name="butacas[]" value="A9"><label for="A9">A9</label></div>
      <div class="seat"><input id="A10" type="checkbox" name="butacas[]" value="A10"><label for="A10">A10</label></div>
      <div class="seat"><input id="B1" type="checkbox" name="butacas[]" value="B1"><label for="B1">B1</label></div>
      <div class="seat"><input id="B2" type="checkbox" name="butacas[]" value="B2"><label for="B2">B2</label></div>
      <div class="seat"><input id="B3" type="checkbox" name="butacas[]" value="B3"><label for="B3">B3</label></div>
      <div class="seat"><input id="B4" type="checkbox" name="butacas[]" value="B4"><label for="B4">B4</label></div>
      <div class="seat"><input id="B5" type="checkbox" name="butacas[]" value="B5"><label for="B5">B5</label></div>
      <div class="seat"><input id="B6" type="checkbox" name="butacas[]" value="B6"><label for="B6">B6</label></div>
      <div class="seat"><input id="B7" type="checkbox" name="butacas[]" value="B7"><label for="B7">B7</label></div>
      <div class="seat"><input id="B8" type="checkbox" name="butacas[]" value="B8"><label for="B8">B8</label></div>
      <div class="seat"><input id="B9" type="checkbox" name="butacas[]" value="B9"><label for="B9">B9</label></div>
      <div class="seat"><input id="B10" type="checkbox" name="butacas[]" value="B10"><label for="B10">B10</label></div>
    </div>
    <div class="legend">
      <span class="dot"></span> Libre
      <span class="dot sel"></span> Seleccionada
      <span class="dot dis"></span> Ocupada (píntala con PHP añadiendo .disabled y deshabilitando el checkbox)
    </div>
  </div>

  <div class="btns">
    <button class="btn btn-primary" type="submit">Confirmar reserva</button>
    <a class="btn btn-outline" href="cartelera.php">Volver</a>
  </div>
</form>

</div></main>
<footer class="footer">
  <div class="container">
    <span>MiniCine · interfaz HTML/CSS — coloca aquí tu lógica PHP (sticky, cookies, sesiones, JSON).</span>
  </div>
</footer>
</body></html>
