<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  $_SESSION["errores"] = $_SESSION["errores"] ?? [];
  $_SESSION["mensajes"] = $_SESSION["mensajes"] ?? [];
  $nombre = $_SESSION["nombre"] ?? "";
  $edad = $_SESSION["edad"] ?? "";
  $sexo=$_SESSION["sexo"]??"";
  $aficiones=$_SESSION["aficiones"]??[];
} else {
  $_SESSION["errores"] = $_SESSION["errores"] ?? [];
  $_SESSION["mensajes"] = $_SESSION["mensajes"] ?? [];
  $nombre = $_POST["nombre"] ?? "";
  $edad = $_POST["edad"] ?? "";
  $sexo=$_POST["sexo"]?? "";
  $aficiones=$_POST["aficiones"]??[];
  $todoOK = true;
  if (empty($nombre)) {
    $_SESSION["errores"][] = "Nombre no puede estar vacio";
    $todoOK = false;
  } else {
    $nombre = trim(htmlspecialchars(strip_tags($nombre)));
    $_SESSION["nombre"] = $nombre;
  }
  if (empty($edad)) {
    $_SESSION["errores"][] = "Edad no puede estar vacio";
    $todoOK = false;
  } else {
    $edad = trim(htmlspecialchars(strip_tags($edad)));
    $_SESSION["edad"] = $edad;
  }
  if (empty($sexo)) {
    $_SESSION["errores"][]="Es obligatorio seleccionar un sexo";
    $todoOK=false;
  }
  else{
    $sexo=trim(htmlspecialchars($sexo));
    $_SESSION["sexo"]=$sexo;
  }
  if (empty($aficiones)) {
    $_SESSION["errores"][]="Marca al menos una aficion";
    $todoOK=false;
  }
  else{
    $_SESSION["aficiones"]=$aficiones;
  }
  if ($todoOK) {
    $_SESSION["mensajes"][] = "Login Correcto";
    header("Location:index.php");
    die;
  } else {
    header("Location:index.php");
    die;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="estilos.css" title="Color">
  <title>03_stickyform</title>
</head>

<body class="body-tipo2">
  <header>
    <h1>3 Sticky form</h1>
  </header>
  <main>

    <!-- usar 
       action = "< ?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  
     -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <p>Nombre: <input type="text" name="nombre" value="<?= $nombre ?>"></p>
      <p>Edad: <input type="text" name="edad" value="<?= $edad ?>"></p>
      </p>
      <input type="radio" id="sexo_masculino" name="sexo" value="m"<?php echo ($sexo==="m")? "checked":"" ?>>
      <label for="sexo_masculino">MASCULINO</label>
      <input type="radio" id="sexo_femenino" name="sexo" value="f"<?php echo ($sexo==="f")? "checked":"" ?>>
      <label for="sexo_femenino">FEMENINO</label>
      <input type="radio" id="sexo_otro" name="sexo" value="o"<?php echo ($sexo==="o")? "checked":"" ?>>
      <label for="sexo_otro">OTRO</label>
      <hr>
      <label for="aficiones">AFICIONES</label><br><br>
      <input type="checkbox" name="aficiones[]" value="musica"<?php echo (in_array("musica",$aficiones))?"checked":"" ?> >Música  
      <input type="checkbox" name="aficiones[]" value="lectura"<?php echo (in_array("lectura",$aficiones))?"checked":"" ?> >Lectura 
      <input type="checkbox" name="aficiones[]" value="deportes"<?php echo (in_array("deportes",$aficiones))?"checked":"" ?> >Deportes
      <input type="checkbox" name="aficiones[]" value="vacaciones"<?php echo (in_array("vacaciones",$aficiones))?"checked":"" ?>>Vacaciones 
      <input type="checkbox" name="aficiones[]" value="cine" <?php echo (in_array("cine",$aficiones))?"checked":"" ?>>Cine <br>
      <p><input type="submit" name="submit" value="Enviar"></p>
    </form>
    <!-- ERRORES Y MENSAJES -->
    <?php
    if (isset($_SESSION["errores"]) && !empty($_SESSION["errores"])) {
      foreach ($_SESSION["errores"] as $error) {
        echo "<p class=error>$error</p>";
      }
    }
    if (isset($_SESSION["mensajes"]) && !empty($_SESSION["mensajes"])) {
      foreach ($_SESSION["mensajes"] as $mensaje) {
        echo "<p class=en_verde>$mensaje</p>";
      }
    }

    unset($_SESSION["errores"]);
    unset($_SESSION["mensajes"]);
    unset($_SESSION["nombre"]);
    unset($_SESSION["edad"]);
    unset($_SESSION["sexo"]);
    unset($_SESSION["aficiones"]);


    ?>
  </main>
  <footer>
    <hr>
    <p>Autor: Juan Antonio Cuello</p>
  </footer>
</body>

</html>