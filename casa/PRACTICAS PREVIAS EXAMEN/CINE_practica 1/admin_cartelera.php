<?php
session_start();
require_once "funciones/utilidades.php";

$esAdmin=$_SESSION["esAdmin"]??false;
if ($esAdmin) {
    $_SESSION["errores"]=$_SESSION["errores"]??[];
    $_SESSION["mensajes"]=$_SESSION["mensajes"]??[];
    $todoOK=true;
    $titulo=$_POST["titulo"]??"";
    if (!empty($titulo)) {
        $titulo=trim(htmlspecialchars(strip_tags($titulo)));
    }
    else{
        $todoOK=false;
        $_SESSION["errores"][]="Titulo es obligatorio";
    }
    $genero=$_POST["genero"]??"";
    if (!empty($genero)) {
        $genero=trim($genero);
    }
    else{
        $todoOK=false;
        $_SESSION["errores"][]="Genero es obligatorio";
    }    
    $duracion=$_POST["duracion"]??"";
    if (!empty($duracion)) {
        $titulo=trim($duracion);
    }
    else{
        $todoOK=false;
        $_SESSION["errores"][]="duracion es obligatorio";
    }
    $sinopsis=$_POST["sinopsis"]??"";
    if (!empty($sinopsis)) {
        $sinopsis=trim(htmlspecialchars(strip_tags($sinopsis)));
    }
    else{
        $todoOK=false;
        $_SESSION["errores"][]="Sinonpsis es obligatorio";
    }
    $precio=$_POST["precio"]??"";
    if (!empty($precio)) {
        $precio=trim(htmlspecialchars(strip_tags($precio)));
    }
    else{
        $todoOK=false;
        $_SESSION["errores"][]="Precio es obligatorio";
    }
    if ($todoOK) {
        if (empty($_FILES["poster"])) {
            $_SESSION["errores"][]="Imagen es obligatorio";
            header("Location:admin_cartelera");
            die;
        }
        else{
            if ($_FILES["poster"]["size"]>1000000) {
                $_SESSION["errores"][]="Imagen demasiado grande";
                header("Location:admin_cartelera.php");
                die;
            }
            else{
                $rutaDestinoImagen="assets/images/imagenes_peliculas";
                $rutaOrigenImagen=$_FILES["poster"]["tmp_name"];
                $nombre_imagen=$_FILES["poster"]["name"];
                if(move_uploaded_f
                ile($rutaOrigenImagen,$rutaDestinoImagen.$nombre_imagen)){
                     
                }
            }
        }
    }                
}
else{
    header("Location:cartelera.php");
    die;
}

?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Administrar cartelera</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  :root{
    --bg:#0f1220; --card:#1a1f36; --ink:#111827; --muted:#6b7280;  --text: #f7f8fc;     --primary: #5b8cff;
    --primary-700: #3d6df0;
    --border:#e5e7eb; --ok:#065f46; --okbg:#ecfdf5; --err:#7f1d1d; --errbg:#fef2f2;
  }
  *{box-sizing:border-box}
  body{margin:0; font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif; background:var(--bg); color:var(--ink)}
  .container{max-width:900px;margin:24px auto;padding:24px;background:var(--card);border-radius:14px;box-shadow:0 8px 24px rgba(0,0,0,.08)}
  h1{color: #ecfdf5; margin:0 0 16px }
  .note{font-size:14px;color:var(--muted);margin-bottom:16px}
  .alert{padding:12px 14px;border-radius:10px;margin-bottom:16px;font-size:14px;border:1px solid transparent;display:none}
  .alert.ok{background:var(--okbg);color:var(--ok);border-color:#a7f3d0}
  .alert.err{background:var(--errbg);color:var(--err);border-color:#fecaca}
  form{display:grid;gap:16px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  @media (max-width:720px){.grid{grid-template-columns:1fr}}
  label{display:block;color: #ecfdf5; font-weight:600;margin-bottom:6px}
  .field{display:flex;flex-direction:column;gap:8px}
  .input{color: #ecfdf5;}
  input[type="text"],
  input[type="number"],
  input[type="date"],
  input[type="file"],
  select,
  textarea{
    width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:10px;font-size:15px;background:#fff
  }
  textarea{min-height:120px;resize:vertical}
  .hint{font-size:12px;color:var(--muted)}
  .actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:8px}
  button{
    background:#111827;color:#fff;border:0;padding:12px 18px;border-radius:10px;
    font-weight:700;cursor:pointer;transition:transform .04s ease,opacity .2s ease
  }
  button:hover{opacity:.95}
  button:active{transform:translateY(1px)}
  .link{display:inline-block;margin-top:8px;color:#2563eb;text-decoration:none}
  .link:hover{text-decoration:underline}
  .error{color:#7f1d1d;}
  .mensaje{color: #065f46;}
</style>
</head>
<body>
  <main class="container">
    <h1>Administrar cartelera</h1>
    <p class="note">Completa los datos de la película y pulsa <strong>Guardar película</strong>. (Este archivo se envía a sí mismo.)</p>

    <!-- Mensajes (muestra/oculta con PHP si quieres) -->
    <div class="alert ok" id="msg-ok">Película añadida correctamente.</div>
    <div class="alert err" id="msg-err">
      <strong>Revisa los siguientes errores:</strong>
      <ul>
        <li>Ejemplo de error 1</li>
        <li>Ejemplo de error 2</li>
      </ul>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
      <div class="grid">
        <div class="field">
          <label for="titulo">Título *</label>
          <input id="titulo" name="titulo" type="text" placeholder="Ej. El Señor de los Anillos" required>
        </div>

        <div class="field">
          <label for="genero">Género *</label>
          <select id="genero" name="genero" required>
            <option value="">-- Selecciona --</option>
            <option>Acción</option>
            <option>Aventura</option>
            <option>Comedia</option>
            <option>Drama</option>
            <option>Terror</option>
            <option>Ciencia Ficción</option>
            <option>Animación</option>
          </select>
        </div>

        <div class="field">
          <label for="duracion">Duración (min) *</label>
          <input id="duracion" name="duracion" type="number" min="1" step="1" placeholder="Ej. 120" required>
        </div>

        <div class="field">
          <label for="estreno">Fecha de estreno</label>
          <input id="estreno" name="estreno" type="date">
        </div>
      </div>

      <div class="field">
        <label for="sinopsis">Sinopsis</label>
        <textarea id="sinopsis" name="sinopsis" placeholder="Breve descripción de la película (opcional)"></textarea>
      </div>

      <div class="grid">
        <div class="field">
          <label for="precio">Precio</label>
          <input id="precio" name="precio" type="text" placeholder="Ej. 7.50">
          <div class="hint">Usa punto como separador decimal (opcional).</div>
        </div>

        <div class="field">
          <label for="poster">Póster (JPG/PNG/WEBP, máx 2MB)</label>
          <input id="poster" name="poster" type="file" accept=".jpg,.jpeg,.png,.webp">
          <div class="hint">Si no subes nada, se guardará sin póster.</div>
        </div>
      </div>

      <div class="actions">
        <button type="submit">Guardar película</button>
        <a class="link" href="cartelera.php">Ver cartelera</a>
      </div>
      <div>
        <!-- AQUI VAN LOS ERRORES DENTRO -->
         <?php  
         ?>
      </div>
    </form>
  </main>
</body>
</html>