<?php 
if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:index.php");
} else {
    //############################## depuracion
     print "<pre>";
     print "Matriz \$_FILES" . "<br>";
     print_r($_FILES);
     print "</pre>\n";
    //#######################################  
    //############################## depuracion
     print "<pre>";
     print "Matriz \$_POST" . "<br>";
     print_r($_POST);
     print "</pre>\n";
    //#######################################        
    $tituloOK=false;$autorOK=false;$anioOk=false;$generosOK=false;$caratulaOK=false;
    $mensajeError="";
    $generos=[];//me creo un array vacio porque los generos seran en formato array.
    //$caratula=[];//me creo un array vacio para rellenar el array de la caratula
    //Comprobaciones de las cosas
    if (isset($_POST["titulo"])&& $_POST["titulo"]!="") {
        $titulo=trim(htmlspecialchars(strip_tags($_POST["titulo"])));
        $tituloOK=true;
    }
    else{
        $mensajeError="ERROR:en el titulo...";
        header("Location:alta.php");
        die;
    }
    if (isset($_POST["autor"])&& $_POST["autor"]!="") {
        $autor=trim(htmlspecialchars(strip_tags($_POST["autor"])));
        $autorOK=true;
    }
    else{
        $mensajeError="ERROR: el autor es incorrecto";
        header("Location:alta.php");
        die;

    }
    if (isset($_POST["anio"]) && $_POST["anio"]!="") {
        $anio=trim(htmlspecialchars(is_numeric($_POST["anio"])));
        $anioOk=true;
    } else {
        $mensajeError="ERROR: año incorrecto";
        header("Location:alta.php");
        die;
    }
    if (isset($_POST["generos"])&& $_POST["generos"]!=[]) {
        $generos=trim(htmlspecialchars(is_array($_POST["generos"])));
        $generosOK=true;
    }
    else{
        $mensajeError="ERROR:los generos no pueden estar vacios";
        header("Location:alta.php");
        die;
    }
    // if (isset($_POST["caratula"]) && $_POST["caratula"]!=[]) {
    //     $caratula=trim(htmlspecialchars(is_array($_POST["caratula"])));
    //     $caratula=true;
    // } else {
    //     $mensajeError="ERROR:la caratula no es correcta...";
    //     header("Location:alta.php");
    //     die;
    // }
    if ($_FILES["caratula"]["size"]>1000000) {//si la caratula es superior a 1mb lanza el error
        $mensajeError="ERROR:tamaño demasiado grande";
        header("Location:alta.php");
        die;
    } else {
        $ruta_subida="bbdd/";
        $resultado=move_uploaded_file($_FILES["caratula"]["tmp_name"],$ruta_subida . $_FILES["caratula"]["name"]);
        echo "estoy en el else del tamaño <br>";
        if ($resultado) {
            $caratula=$_FILES["caratula"]["name"];
            $caratulaOK=true;
        }
        else{
            echo "NO entro en el if resultado <br>";
            echo $_FILES["caratula"]["tmp_name"]."<br>";
            echo $_FILES["caratula"]["name"]."<br>";
        }
    }

    include_once("modelo/libro.php");//le incluyo el libro

    //Despues de las comprobaciones si todo ha ido bien me creo el libro
    if ($caratulaOK) {
        echo "caratula OK <br>";
        echo $caratula;
    }
    else{
        echo "caratula incorrecta <br>";
    }
    if ($tituloOK && $autorOK && $anioOk && $generosOK && $caratulaOK) {
        //si todo es correcto me creo el libro con las variables cogidas en el post
        $bbdd_libros=[];
        $nuevo_libro=new Libro($titulo,$autor,$anio,$generos,$caratula);
        $bbdd_json=file_get_contents("bbdd/data.json",FILE_USE_INCLUDE_PATH);
        $bbdd_libros=json_decode($bbdd_json);
        echo "<hr>";


        array_push($bbdd_libros,$nuevo_libro);
        $bbdd_json=json_encode($bbdd_libros,JSON_UNESCAPED_UNICODE |JSON_PRETTY_PRINT);
        file_put_contents("bbdd/data.json",$bbdd_json);//sobreescribe el archivo con los nuevos cambios
        $mensaje="ALTA CORRECTO";
        header("Location: alta.php?mensaje=$mensaje");
        die;
    }
    else{
        echo "console.log('todo ha ido mal...')";
    }
    
    
    
}


?>