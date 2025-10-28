<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro · MiniCine</title>
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

<h2>Registro</h2>
<form class="form" method="post" action="<?php  ?>">
  <div class="alert alert-error" id="reg-errors" style="display:none;">Aquí pintarás errores desde PHP</div>
  <div class="form-row">
    <div class="field">
      <label for="email">Email</label>
      <input class="input" type="email" id="email" name="email" placeholder="tue@mail.com" value="">
      <!-- Sticky sugerido: value="<?= htmlspecialchars($old['email'] ?? '') ?>" -->
    </div>
    <div class="field">
      <label for="rol">Rol</label>
      <select id="rol" name="rol">
        <option value="user" selected>Usuario</option>
        <option value="admin">Admin</option>
      </select>
      <span class="small">(Solo a efectos de prueba; en producción fija a user).</span>
    </div>
  </div>
  <div class="form-row">
    <div class="field">
      <label for="password">Contraseña</label>
      <input class="input" type="password" id="password" name="password" placeholder="mín. 8, letra y número">
    </div>
    <div class="field">
      <label for="password2">Repite contraseña</label>
      <input class="input" type="password" id="password2" name="password2" placeholder="••••••••">
    </div>
  </div>

  <div class="inline">
    <input type="checkbox" id="cond" name="cond">
    <label for="cond">Acepto las condiciones</label>
  </div>

  <!-- CSRF -->
  <input type="hidden" name="csrf_token" value="">

  <div class="btns">
    <button class="btn btn-primary" type="submit">Crear cuenta</button>
    <a class="btn btn-outline" href="login.php">Ya tengo cuenta</a>
  </div>
</form>

</div></main>
<footer class="footer">
  <div class="container">
    <span>MiniCine · interfaz HTML/CSS — coloca aquí tu lógica PHP (sticky, cookies, sesiones, JSON).</span>
  </div>
</footer>
</body></html>
