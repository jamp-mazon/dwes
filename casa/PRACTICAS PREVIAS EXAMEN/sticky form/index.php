<?php 
session_start();
// print("<pre>");
// print_r($_SESSION);
// print("</pre>");
if ($_SERVER["REQUEST_METHOD"]!=="POST") {
  $nombre=$_SESSION["nombre"]??="";
  $edad=$_SESSION["edad"]??"";
}
else{
  $_SESSION["errores"]=$_SESSION["errores"]??[];
  $_SESSION["mensajes"]=$_SESSION["mensajes"]??[];
  //COMPRUEBO EL POST
  $nombre=$_POST["nombre"]??"";
  $edad=$_POST["edad"]??"";
  
  if (empty($nombre)) {
      $_SESSION["errores"][]="El nombre no puede estar vacio";
  }
  else{
    $_SESSION["nombre"]=$nombre;
    $nombreOK=true;
  }
  if (empty($edad)) {
      $_SESSION["errores"][]="La edad no puede estar vacia";
  }
  else{
    $_SESSION["edad"]=$edad;
    $edadOK=true;
  }
  if ($nombreOK && $edadOK) {
      $_SESSION["mensajes"][]="Login Correcto";
      header("Location:index.php");
      die;
  }
  else{
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
      <p>Nombre: <input type="text" name="nombre" value="<?=$nombre?>"></p>
      <p>Edad: <input type="text" name="edad" value="<?=$edad?>"></p>
      </p>
      <p><input type="submit" name="submit" value="Enviar"></p>
    </form>
    <?php
      if (!empty($_SESSION["errores"])) {
          foreach ($_SESSION["errores"] as $error) {
            echo "<p class='error'>$error</p>";
          }
      }
      if (!empty($_SESSION["mensajes"])) {
          foreach ($_SESSION["mensajes"] as $mensaje) {
            echo "<p class='error'>$mensaje</p>";
          }
      }
      unset($_SESSION["errores"]);
      unset($_SESSION["mensajes"]);
      unset($_SESSION["nombre"]);
      unset($_SESSION["edad"]);      
    ?>
  </main>
  <footer>
    <hr>
    <p>Autor: Jose Antonio Mazon</p>
  </footer>
</body>

</html>