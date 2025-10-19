<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //si vengo del submit
  //print("<pre>");
  //print_r($_SESSION);
  //print("</pre>");
  $todoOK = true; // <-- inicializar a true y invalidar cuando hay errores

  //Comprobacion del nombre
  if (!empty($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    $_SESSION["nombre"] = $nombre;
  } else {
    $nombre = "";
    $_SESSION["errores"]["nombre"] = "Nombre incorrecto o vacio";
    $todoOK = false; // <-- marcar error
  }

  //Comprobacion de la edad
  if (!empty($_POST["edad"])) {
    $edad = $_POST["edad"];
    $_SESSION["edad"] = $edad;
  } else {
    $edad = "";
    $_SESSION["errores"]["edad"] = "Edad incorrecta o vacia";
    $todoOK = false;
  }

  //Comprobacion de los radios
  if (!empty($_POST["sexo"])) {
    $sexo = $_POST["sexo"];
    $_SESSION["sexo"] = $sexo;
  } else {
    $sexo = "";
    $_SESSION["errores"]["sexo"] = "El campo es obligatorio.";
    $todoOK = false;
  }

  //comprobacion de los checkBox
  if (!empty($_POST["aficiones"])) {
    $aficiones = $_POST["aficiones"];
    $_SESSION["aficiones"] = $aficiones;
  } else {
    $aficiones = [];
    $_SESSION["errores"]["aficiones"] = "Hay que seleccionar al menos una aficion";
    $todoOK = false;
  }

  if ($todoOK) {
    header("Location:mostrar_datos.php");
    die;
  } else {
    header("Location:index.php");
    die; // <-- importante para evitar que el script siga ejecutándose
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
      <p>Nombre: <input type="text" name="nombre" value="<?php echo !empty($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?>"></p>
      <p>Edad: <input type="text" name="edad" value="<?php echo !empty($_SESSION["edad"]) ? $_SESSION["edad"] : "" ?>"></p>
      </p>
      <input type="radio" id="sexo_masculino" name="sexo" value="M" <?php echo isset($_SESSION['sexo']) && $_SESSION['sexo'] == "M" ? "checked" : ""; ?>>
      <label for="sexo_masculino">MASCULINO</label>

      <input type="radio" id="sexo_femenino" name="sexo" value="F" <?php echo isset($_SESSION['sexo']) && $_SESSION['sexo'] == "F" ? "checked" : ""; ?>>
      <label for="sexo_femenino">FEMENINO</label>

      <input type="radio" id="sexo_otro" name="sexo" value="O" <?php echo isset($_SESSION["sexo"]) && $_SESSION["sexo"] == "O" ? "checked": "" ?>>
      <label for="sexo_otro">OTRO</label>
      <hr>
      <input type="checkbox" name="aficiones[]" value="musica" <?php echo isset($_SESSION["aficiones"]) && in_array("musica",$_SESSION["aficiones"]) ? "checked":"" ?> > Música
      <input type="checkbox" name="aficiones[]" value="futbol" <?php echo isset($_SESSION["aficiones"]) && in_array("futbol",$_SESSION["aficiones"]) ? "checked":"" ?>  > Fútbol
      <input type="checkbox" name="aficiones[]" value="lectura" <?php echo isset($_SESSION["aficiones"]) && in_array("lectura",$_SESSION["aficiones"]) ? "checked":"" ?>  > Lectura
      <input type="checkbox" name="aficiones[]" value="cine" <?php echo isset($_SESSION["aficiones"]) && in_array("cine",$_SESSION["aficiones"]) ? "checked":"" ?>  > Cine<br />


      <p><input type="submit" name="submit" value="Enviar"></p>
    </form>
    <p>
      <?php
      if (!empty($_SESSION["errores"]["nombre"])) {
        echo "<p class='error'>" . $_SESSION['errores']['nombre'] . "</p>";
      }
      ?>
    </p>
    <p>
      <?php
      if (!empty($_SESSION["errores"]["edad"])) {
        echo "<p class='error'>" . $_SESSION['errores']['edad'] . "</p>";
      }
      ?>
    </p>

    <?php
    unset($_SESSION["errores"]);
    unset($_SESSION["nombre"]);
    unset($_SESSION["edad"]);
    ?>
  </main>
  <footer>
    <hr>
    <p>Autor: Jose Antonio Mazón</p>
  </footer>
</body>

</html>