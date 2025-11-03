<?php
session_start();
if (!isset($_SESSION["form1"])|| $_SESSION["form1"]!==true) {
  header("Location:formulario1.php");
  die;
}
$nombre=$_SESSION["nombre"]??"";
$curso=$_SESSION["curso"]??"";
$lista_errores=$_SESSION["errores"]??[];
$lista_daw=$_SESSION["daw1"]??[];


?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilos.css" title="Color">
  <title>Sticky</title>
</head>

<body class="body-gris">
  <header>
    <h1>FORMULARIO DE MATRICULACION</h1>
    <h2>Eleccion de materias de <?=$nombre?></h2>
  </header>
  <main>
          
        <!-- 


        -->
    <form action="procesar.php" method="POST">
        <p>
            <button type="submit" name="anterior">ANTERIOR</button>  
            <button type="submit" name="mostrar">MOSTRAR DATOS</button>
        </p>
        <!-- CLASS1 -->
         <?php if ($curso==="daw1"): ?>
        <input type="checkbox" name="daw[]" value="programacion" <?php echo in_array("programacion",$lista_daw)? "checked":"" ?>>Programación<br />
        <input type="checkbox" name="daw[]" value="basedatos" <?php echo in_array("basedatos",$lista_daw)? "checked":"" ?>>Bases de Datos<br />
        <input type="checkbox" name="daw[]" value="lmarcas" <?php echo in_array("lmarcas",$lista_daw)? "checked":"" ?>>Lenguaje de Marcas<br />
        <input type="checkbox" name="daw[]" value="ingles" <?php echo in_array("ingles",$lista_daw)? "checked":"" ?>>Ingles<br />
        <input type="checkbox" name="daw[]" value="digitalizacion" <?php echo in_array("digitalizacion",$lista_daw)? "checked":"" ?>>Digitalizacion<br />
        <?php endif; ?>
        <!-- CLASS2 -->
         <?php if ($curso==="daw2"): ?>
        <input type="checkbox" name="daw[]" value="servidor" <?php echo in_array("servidor",$lista_daw)? "checked":"" ?>>Desarrollo Web Servidor<br />
        <input type="checkbox" name="daw[]" value="cliente" <?php echo in_array("cliente",$lista_daw)? "checked":"" ?>>Desarrollo Web Cliente<br />
        <input type="checkbox" name="daw[]" value="interfaces" <?php echo in_array("interfaces",$lista_daw)? "checked":"" ?>>Diseño de Interfaces<br />
        <input type="checkbox" name="daw[]" value="ia" <?php echo in_array("ia",$lista_daw)? "checked":"" ?>>IA generativa<br />
        <input type="checkbox" name="daw[]" value="despliegue" <?php echo in_array("despliegue",$lista_daw)? "checked":"" ?>>Despliegue<br /> 
        <?php endif; ?>
        
    </form>
        <?php foreach ($lista_errores as $error):?>
          <p class="error"><?=$error?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION["errores"]); ?>
  </main>
  <footer>
    <hr>
    <p>IES Floridablanca</p>
  </footer>
</body>

</html>



