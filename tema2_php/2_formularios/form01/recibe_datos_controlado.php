<?php
## Recogemos los datos con POST, y solo permitimos POST

if ($_SERVER["REQUEST_METHOD"] !="POST") {
    echo ("Petición no válida (Hay que pasar por el formulario)");
    //Volvemos al formulario
    print "<p> <a href='index.html'>Formulario </a> </p>";
}
else{

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
    //Muestro datos
    if (isset($nombre)) {
        echo ("Nombre: $nombre <br>");
    } else {
        echo ("ERROR: $nombreError <br>");
    }
    if (isset($edad)) {
        echo ("Edad: $edad <br>");
    } else {
        echo ("ERROR: $edadError <br>");
    }  
    //Volvemos al formulario. No seria necesario. Es solo por volver mas rapidamente
    print "<p> <a href='index.html'>Formulario </a> </p>";
    
}
?>