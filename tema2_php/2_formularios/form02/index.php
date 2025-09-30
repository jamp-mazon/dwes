<?php


if ($_SERVER["REQUEST_METHOD"]=="POST"){//si se pulsa el submit entra si no no...
  //$nombre=$_POST["nombre"];
  print "<pre>";
  print_r ($_POST);
  print "</pre>\n";
    if (isset($_POST['nombre']) && $_POST["nombre"]!="" ) {//si con isset regoce nombre y el nombre no esta vacia
        //$nombre=$_POST["nombre"];
        $nombre=trim(htmlspecialchars(strip_tags($_POST["nombre"])));
    }
    else{
        $nombreError="No se ha escrito ningun nombre";
    }
    //Compruebo que existe el campo edad y que no es vacio
    if (isset($_POST['edad']) && $_POST["edad"]!="") {//si con isset regoce nombre y el nombre no esta vacia
        //$edad=$_POST["edad"];
        
        if (is_numeric($_POST["edad"]) && $_POST["edad"]>0 && $_POST["edad"]<150) {
            $edad=$_POST["edad"];
        }
        else {
            $edadError="edad fuera de rango<br>";
        }
    }
    else{
        $edadError="No se ha indicado la edad";  
    }
}    
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="estilos.css" title="Color">
  <title>form_02</title>
</head>

<body>
  <h1>####################Incompleto####################</h1>
  <header>
    <h1>Formulario 02 - el form recibe los datos</h1>
  </header>
  <main>
    
    <!-- usar 
       action = "< ?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  
     -->
    <form action="index.php" method="post">
        <fieldset>
          <legend>Envio tipo POST</legend>
          <p>
            <!-- al usar <label> y que coincida con el id del <input> correspondiente, permite que al hacer click 
            en el texto del <label>, el cursor se coloque directamente en el campo asociado -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre">
          </p>
          <p>
            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad">
          </p>
            <p>
                <input type="radio" id="sexo_masculino" name="sexo" value="M">
                <label for="sexo_masculino">MASCULINO</label>
                <input type="radio" id="sexo_femenino" name="sexo" value="F">
                <label for="sexo_femenino">FEMENINO</label>
                <input type="radio" id="sexo_otros" name="sexo" value="0">
                <label for="sexo_otros">OTROS</label>
            </p>
          <p>
            <input type="checkbox" name="aficiones[]" value="musica">Musica<br>
            <input type="checkbox" name="aficiones[]" value="cine">Cine<br>
            <input type="checkbox" name="aficiones[]" value="lectura">Lectura<br>
          </p>
          <p>
            <button type="submit">Enviar</button>
            <button type="reset">Borrar</button>
          </p>
        </fieldset>

    </form>
    <?php
    //Muestro datos
    if (isset($nombreError)){//el isset sirve para saber si existe contenido o no dentro o bien de la variable o de un array concreto
      print "<p class='error'>$nombreError</p>";
    }
    if (isset($nombreError)){
      print "<p class='error'>$edadError</p>";
    }    
    ?>

    
    <br><br>
    <div class="datos-recibidos">
      <?php
      if (isset($nombre) && isset($edad)) {
        print "- Nombre: $nombre <br>";
        print "- Edad: $edad <br>";
      }

    ?>
    </div>
    

    
  </main>
  <footer>
    <hr>
    <p>Autor: Juan Antonio Cuello</p>
  </footer>
  </body>
</html>