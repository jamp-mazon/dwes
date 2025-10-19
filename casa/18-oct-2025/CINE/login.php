<?php
session_start();
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <style>
    /* --- Reset suave --- */
    *, *::before, *::after { box-sizing: border-box; }
    body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial, "Apple Color Emoji", "Segoe UI Emoji"; }

    /* --- Layout centrado --- */
    .wrap {
      min-height: 100svh;               /* que ocupe toda la pantalla */
      display: grid;                    /* centrado simple */
      place-items: center;
      background: linear-gradient(135deg, #eceff4, #e5f2ff);
      padding: 16px;
    }

    /* --- Tarjeta --- */
    .card {
      width: 100%;
      max-width: 380px;
      background: #fff;
      border: 1px solid #e6e6e6;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 10px 30px rgba(0,0,0,.06);
    }

    .card h1 {
      margin: 0 0 16px;
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: .2px;
      color: #111827;
    }

    .card p.sub {
      margin: 0 0 20px;
      color: #6b7280;
      font-size: .95rem;
    }

    /* --- Formulario --- */
    form { display: grid; gap: 14px; }

    label { font-size: .9rem; color: #374151; }

    .field { display: grid; gap: 6px; }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      border: 1px solid #d1d5db;
      border-radius: 10px;
      font-size: 1rem;
      color: #111827;
      background: #fff;
      transition: border-color .15s ease, box-shadow .15s ease;
    }

    input::placeholder { color: #9ca3af; }

    input:focus-visible {
      outline: none;
      border-color: #2563eb;            /* azul */
      box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
    }

    /* --- fila opciones --- */
    .row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      margin-top: 4px;
    }

    .row label.inline {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: .9rem;
      color: #4b5563;
      user-select: none;
      cursor: pointer;
    }

    .link { color: #2563eb; text-decoration: none; font-size: .9rem; }
    .link:hover { text-decoration: underline; }

    /* --- Botón --- */
    button[type="submit"] {
      margin-top: 6px;
      padding: 12px 14px;
      width: 100%;
      border: 0;
      border-radius: 10px;
      font-weight: 700;
      font-size: 1rem;
      color: #fff;
      background: #2563eb;
      cursor: pointer;
      transition: filter .15s ease, transform .02s ease;
    }

    button[type="submit"]:hover { filter: brightness(1.05); }
    button[type="submit"]:active { transform: translateY(1px); }

    /* --- pie --- */
    .foot {
      margin-top: 14px;
      font-size: .9rem;
      color: #6b7280;
      text-align: center;
    }
    .error{
      color: red;
    }
  </style>
</head>
<body>
    <header class="bg-black text-white h-20 text-center p-5">
        <h1>SUPERCINES</h1>
    </header>    
  <main class="wrap">
    <section class="card" aria-labelledby="titulo-login">
      <h1 id="titulo-login">Iniciar sesión</h1>
      <p class="sub">Accede con tu correo y contraseña.</p>

      <form action="procesarLog.php" method="post" novalidate>
        <!-- Email -->
        <div class="field">
          <label for="email">Correo electrónico</label>
          <input id="email" name="email" type="email" placeholder="tu@correo.com" required autocomplete="email" />
        </div>

        <!-- Password -->
        <div class="field">
          <label for="pass">Contraseña</label>
          <input id="pass" name="password" type="password" placeholder="••••••••" minlength="6" required autocomplete="current-password" />
        </div>

        <div class="row">
          <label class="inline">
            <input type="checkbox" name="remember" />
            Recuérdame
          </label>
          <a class="link" href="#">¿Olvidaste la contraseña?</a>
        </div>

        <button type="submit">Entrar</button>

        <p class="foot">¿No tienes cuenta? <a class="link" href="#">Regístrate</a></p>
      </form>
          <?php
            
            if (!empty($_SESSION["errores"])) { 
              foreach ($_SESSION["errores"] as $error) {
                  echo "<p class='error'>$error</p>";

                }
              }
              
              ?>


    </section>
  </main>
    <footer class="bg-black text-white h-20 text-center p-5">
        <h2>UN FORMULARIO PARA DOMINARLOS A TODOS</h2>
    </footer>  
</body>
</html>
