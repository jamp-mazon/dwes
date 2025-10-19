<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") { //si vengo del submit
  //Comprobacion del nombre
  if (!empty($_POST["nombre"])) { //si existe "post nombre" o no esta vacio
    $nombre = $_POST["nombre"]; //me lo guardo en una variable
    $_SESSION["nombre"] = $nombre; //me guardo la session del nombre para mostrarlo luego.
  } else { //si no existe el post nombre o esta vacio
    $nombre = ""; //si no existe me lo creo vacio
    $_SESSION["errores"]["nombre"] = "Nombre incorrecto o vacio";
    //header("Location:index.php");

  }
  //Comprobacion de la edad  

  if (!empty($_POST["edad"])) {
    $edad = $_POST["edad"];
    $_SESSION["edad"] = $edad;
  } else {
    $edad = "";
    $_SESSION["errores"]["edad"] = "Edad incorrecta o vacia";
    //header("Location:index.php");

  }
  //SI las variables session edad y nombre son true me voy a mostrar los datos.
  if (!empty($_SESSION["nombre"]) && !empty($_SESSION["edad"])) {
    header("Location:mostrar_datos.php");
    die;
  }
  //Comprobacion de los radios
  
  //comprobacion de los checkBox

  
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

      <input type="radio" id="sexo_femenino" name="sexo" value="F" <?php echo isset($_SESSION['sexo']) && $_SESSION['sexo'] == "M" ? "checked" : ""; ?>>
      <label for="sexo_femenino">FEMENINO</label>

      <input type="radio" id="sexo_otro" name="sexo" value="O" <?php ?>>
      <label for="sexo_otro">OTRO</label>
      <hr>
      <input type="checkbox" name="aficiones[]" value="musica" <?php ?> > Musica
      <input type="checkbox" name="aficiones[]" value="futbol" <?php ?> > Futbol
      <input type="checkbox" name="aficiones[]" value="lectura" <?php ?> > Lectura
      <input type="checkbox" name="aficiones[]" value="cine" <?php ?> > Cine<br />


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