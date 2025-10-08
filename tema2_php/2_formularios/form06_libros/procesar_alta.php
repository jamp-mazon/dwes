<?php 
if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:index.php");
} else {
    $tituloOK=false;$autorOK=false;$anioOk=false;$generosOK=false;$caratulaOK=false;
    $mensajeError="";
    //Comprobaciones de las cosas
    if (isset($_POST["titulo"])&& $_POST["titulo"]!="") {
        $titulo=trim(htmlspecialchars(strip_tags($_POST["titulo"])));
        $tituloOK=true;
    }
    else{
        $mensajeError="ERROR:en el titulo...";
    }
    if (isset($_POST["autor"])&& $_POST["autor"]!="") {
        $autor=trim(htmlspecialchars(strip_tags($_POST["autor"])));
        $autorOK=true;
    }
    else{
        $mensajeError="ERROR: el autor es incorrecto";
    }
    if (isset($_POST["anio"]) && $_POST["anio"]!="") {
        $anio=trim(htmlspecialchars(is_numeric($_POST["anio"])));
        $anioOk=true;
    } else {
        $mensajeError="ERROR: año incorrecto";
    }
    
}


?>