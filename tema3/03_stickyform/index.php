<?php
session_start();
require_once "includes/funciones.php";
if (!empty($_SESSION["edad"])) {
  $edad=$_SESSION["edad"];
}
else{
  $edad="";
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
    <form action="procesar.php" method="post">
      <p>Nombre: <input type="text" name="nombre" value="<?php echo !empty($_SESSION["nombre"]) ? $_SESSION["nombre"] : ""; ?>" ></p>
      <p>Edad: <input type="text" name="edad" value="<?=$edad ?>" ></p>
      </p>
      <p><input type="submit" name="submit" value="Enviar"></p>
    </form>
    <?php
      //Muestro errores si los hay
      if (isset($_SESSION["error"]["nombre"])) {
        print "<p class='error'>".$_SESSION['error']['nombre']."</p>";
      }
      if (isset($_SESSION["error"]["edad"])) {
        print "<p class='error'>".$_SESSION['error']['edad']."</p>";
      }     
      //Debemos resetear los errores despues de mostrarlos.Tambien los date_offset_get
      unset ($_SESSION["error"]["nombre"]);
      unset ($_SESSION["error"]["edad"]);
      //Tambien los datos correctros Ya los he puesto en el form
      unset ($_SESSION["nombre"]);
      unset ($_SESSION["edad"]);       
    ?>

  </main>
  <footer>
    <hr>
    <p>Autor: Juan Antonio Cuello</p>
  </footer>
</body>

</html>