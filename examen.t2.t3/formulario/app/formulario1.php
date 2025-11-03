<?php
session_start();
$lista_errores=[];
if (isset($_SESSION["errores"])&& !empty($_SESSION["errores"])) {
  $lista_errores=$_SESSION["errores"];
}
$nombre=$_SESSION["nombre"]??"";
$curso=$_SESSION["curso"]??"";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilos.css" title="Color">
  <title>Formulario</title>
</head>

<body class="body-gris">
  <header>
    <h1>FORMULARIO DE MATRICULACION</h1>
    <h2>Datos alumno y curso</h2>
  </header>
  <main>
 
    <form action="procesar.php" method="post">
      <p>
         <label for="nombre">Nombre:</label>
         <input type="text" id="nombre" name="nombre" value="<?=$nombre?>">
      </p>
      
      <p>
        <input type="radio" id="daw1" name="curso" value="daw1"<?php echo ($curso==="daw1")? "checked":"";  ?> >
        <label for="daw1">DAW1</label>

        <input type="radio" id="daw2" name="curso" value="daw2"<?php echo ($curso==="daw2")? "checked":"";  ?> >
        <label for="daw2">DAW2</label>
      </p>
      
      <p><button type="submit" name="form1">SIGUIENTE</button></p>

    </form>
    <?php foreach ($lista_errores as $error): ?>
      <p class="error"><?=$error?></p>
    <?php endforeach; ?> 
    <?php unset($_SESSION["errores"]) ?> 
  </main>
  <footer>

    <hr>
    <p>IES Floridablanca</p>
  </footer>
</body>
</html>



