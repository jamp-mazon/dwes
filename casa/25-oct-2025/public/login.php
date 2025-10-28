<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login · MiniCine</title>
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

<h2>Acceder</h2>
<div class="grid">
  <form class="form" method="post" action="">
    <div class="alert alert-error" id="login-errors" style="display:none;">Aquí pintarás errores desde PHP</div>

    <div class="field">
      <label for="email">Email</label>
      <input class="input" type="email" id="email" name="email" placeholder="tue@mail.com" value="">
      <!-- Sticky sugerido en PHP: value="<?= htmlspecialchars($old['email'] ?? ($_COOKIE['remember_email'] ?? '')) ?>" -->
    </div>

    <div class="field">
      <label for="password">Contraseña</label>
      <input class="input" type="password" id="password" name="password" placeholder="••••••••">
    </div>

    <div class="inline">
      <input type="checkbox" id="remember" name="remember">
      <label for="remember">Recordar email (cookie 7 días)</label>
    </div>

    <!-- CSRF -->
    <input type="hidden" name="csrf_token" value="">
    <!-- Rellena el value con tu token generado en PHP -->

    <div class="btns">
      <button class="btn btn-primary" type="submit">Entrar</button>
      <a class="btn btn-outline" href="register.php">Crear cuenta</a>
    </div>
  </form>
</div>

</div></main>
<footer class="footer">
  <div class="container">
    <span>MiniCine · interfaz HTML/CSS — coloca aquí tu lógica PHP (sticky, cookies, sesiones, JSON).</span>
  </div>
</footer>
</body></html>
