<?php
session_start();
include_once "includes/Peliculas.php";
print("<pre>");
print_r($_SESSION);
print("</pre>");  

    if ($_SESSION["loginOK"] && $_SESSION["esAdmin"]) {

        $todoOK=true;
        if ($_SERVER["REQUEST_METHOD"]=="POST") {        
                    $_SESSION["errores"]=[];
                    $_SESSION["mensajes"]=[];
                $titulo=$_POST["titulo"] ?? "";
                if (empty($titulo)) {
                    $_SESSION["errores"][]="Titulo con formato incorrecto";
                    $todoOK=false;
                    header("Location:admin_cartelera.php");
                    die;
                }
                $categoria=$_POST["genero"] ?? "";
                if (empty($categoria)) {
                    $todoOK=false;
                    $_SESSION["errores"][]="Pelicula tiene que tener un genero";
                    header("Location:admin_cartelera.php");
                    die;
                }
                $duracion=$_POST["duracion"] ?? "";
                if (empty($duracion) && !is_numeric($duracion)) {
                    $todoOK=false;
                    $_SESSION["errores"][]="La pelicula debe tener una duracion minima.";
                    header("Location:admin_cartelera.php");
                    die;
                }
                $estreno=$_POST["estreno"] ?? "";
                if (empty($estreno)) {
                    $todoOK=false;
                    $_SESSION["errores"][]="Error en la fecha de estreno";
                    header("Location:admin_cartelera.php");
                    die;
                }
                else{
                    $_SESSION["fecha_estreno"]=$estreno;
                }
                $sinopsis=$_POST["sinopsis"] ?? "";
                if (empty($sinopsis)) {
                    $todoOK=false;
                    $_SESSION["errores"][]="La pelicuta tiene que tener una descripcion";
                    header("Location:admin_cartelera.php");
                    die;
                }
                $precio=$_POST["precio"] ?? "";
                if (empty($precio) && !is_numeric($precio)) {
                    $todoOK=false;
                    $_SESSION["errores"][]="La pelicula debe tener un precio.";
                    header("Location:admin_cartelera.php");
                    die;
                }
                else{
                    $_SESSION["precio_pelicula"]=$precio;
                }
                $imagen=$_FILES["poster"] ?? "";
                if (!is_array($imagen) && empty($imagen)) {
                    $todoOK=false;
                    $_SESSION["errores"][]="La imagen esta un formato incorrecto";
                    header("Location:admin_cartelera.php");
                    die;
                }
                else{
                    if ($_FILES["poster"]["size"]>2000000) {
                    $todoOK=false;
                    $_SESSION["errores"][]="La imagen es demasiado grande";
                    header("Location:admin_cartelera.php");
                    die;                        
                    }
                    else{
                        $ruta_imagen="assets/images/imagenes_peliculas/";
                        $nombre_imagen=$_FILES["poster"]["name"];
                        $guardada_imagen=move_uploaded_file($_FILES["poster"]["tmp_name"],$ruta_imagen.$nombre_imagen);
                        if ($guardada_imagen) {
                            $_SESSION["mensajes"][]="Imagen guardada con exito!!";
                            if ($todoOK) {
                                $lista_peliculas=[];
                                $nueva_pelicula=new Pelicula($titulo,$duracion,$categoria,$sinopsis,$nombre_imagen);
                                $ruta_bbdd="bbdd/peliculas.json";
                                $peliculas_json=file_get_contents($ruta_bbdd,FILE_USE_INCLUDE_PATH);
                                $lista_peliculas=json_decode($peliculas_json);// en teoria tengo la lista de peliculas
                                array_push($lista_peliculas,$nueva_pelicula);
                                $peliculas_json=json_encode($lista_peliculas,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
                                file_put_contents($ruta_bbdd,$peliculas_json);
                            }
                        }
                        else{
                            $todoOK=false;
                            $_SESSION["errores"][]="Error al guardar la imagen";
                            header("Location:admin_cartelera.php");
                            die;                                
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
            if (isset($_SESSION["errores"]) && $_SESSION["errores"]!=[]) {
                foreach ($_SESSION["errores"] as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
            if (!empty($_SESSION["mensajes"])) {
                foreach ($_SESSION["mensajes"] as $mensaje) {
                    echo "<p class='mensaje'>$mensaje</p>";
                }
            }
              
         ?>
      </div>
    </form>
  </main>
</body>
</html>