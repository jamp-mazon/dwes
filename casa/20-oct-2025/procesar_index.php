<?php
session_start();
include_once "includes/Usuario.php";

    if ($_SERVER["REQUEST_METHOD"]!="POST") {
        header("Location:index.php");
        die;
    }
    else{
        //empiezo la recogida de datos
        //me creo una session de errores vacia
        $_SESSION["errores"]=[];
        $todoOK=true;//lo pongo a falso si algo sale mail
        if (isset($_POST["nick"]) && $_POST["nick"]!="") {
            $nick=trim(htmlspecialchars(strip_tags($_POST["nick"])));
            $_SESSION["nick"]=$nick;
        }
        else{
            $todoOK=false;
            $_SESSION["errores"][]="El nick no es correcto";
        }
        if (isset($_POST["email"]) && $_POST["email"]!="") {
            if(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
                $email=trim($_POST["email"]);
                $_SESSION["email"]=$email;                
            }
            else{
                $todoOK=false;
                $_SESSION["errores"][]="Error en el formato del email1";                
            }

        }
        else{
            $todoOK=false;
            $_SESSION["errores"][]="Error no puede estar vacio email";
        }
            $passwordOK=true;
        if (isset($_POST["password1"]) && $_POST["password1"]!="") {
            $password1=trim($_POST["password1"]);
            
        }
        else{
            $todoOK=false;
            $passwordOK=false;
            $_SESSION["errores"][]="Error en la contraseña";
        }
        if (isset($_POST["password2"]) && $_POST["password2"]!="") {
            $password2=trim($_POST["password2"]);
            
        }
        else{
            $todoOK=false;
            $passwordOK=false;
            $_SESSION["errores"][]="Error en la contraseña";
        }
        if ($passwordOK) {
            if ($password1!==$password2) {
                $todoOK=false;
                $_SESSION["errores"][]="Las contraseñas tienen que coincidir";
            }
        }
        if (isset($_POST["sexo"])) {
            $sexo=$_POST["sexo"];
            $_SESSION["sexo"]=$sexo;
        }
        else{
            $todoOK=false;
            $_SESSION["errores"][]="El sexo es obligatorio.";
        }
        if (isset($_POST["categorias"])) {
            $categorias=$_POST["categorias"];
            $_SESSION["categorias"]=$categorias;
        }
        else{
            $todoOK=false;
            $_SESSION["errores"][]="Las categorias son obligatorias";
        }
        if ($_FILES["avatar"]["size"]>2000000) {
            $todoOK=false;
            $_SESSION["errores"][]="La imagen es demasiado pesada";
        }
        else{
            $ruta_imagen="assets/images/imagenes_usuario";//guardo la ruta de destino de la imagen
            $imagen=$_FILES["avatar"]["name"];//me guardo el nombre de la imagen
            $mover_imagen=move_uploaded_file($_FILES["avatar"]["tmp_name"],$ruta_imagen.$imagen);//muevo del origen al destino
            if (!$mover_imagen) {
                $todoOK=false;
                $_SESSION["errores"][]="la imagen no guardo correctamente";
            }
        }
        if ($todoOK) {//si esta todo OK me creo el usuario y entonces 
            $lista_usuarios=[];//me creo una lista de usuarios vacia.
            $usuario=new Usuario($nick,$email,$password1,$sexo,$categorias,$imagen,false);
            $ruta_bbdd="bbdd/usuarios.json";//cojo la ruta de la bbdd del json
            $usuarios_json=file_get_contents($ruta_bbdd,FILE_USE_INCLUDE_PATH);//tengo los usuarios en formato json
            
            $lista_usuarios=json_decode($usuarios_json);//meto los usuarios en mi array vacio haciendolos un objeto
            if (is_null($lista_usuarios)) {
                $_SESSION["errores"][]="La lista de usuarios no se hace bien";
                header("Location:index.php");
                die;
            }
            if(array_push($lista_usuarios,$usuario)){
                $usuarios_json=json_encode($lista_usuarios,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//lo hago en formato json
                file_put_contents($ruta_bbdd,$usuarios_json);//sobreescribo los datos actuales de usuarios.json
                $_SESSION["loginOK"]=true;
                header("Location:cartelera.php");
                die;    
            }
            else{
                $_SESSION["errores"][]="Array pusheado incorrectamente";
                header("Location:index.php");
            }
                //meto el usuario en la lista de usuarios

        }
        else{
            $_SESSION["loginOK"]=false;
            $_SESSION["errores"][]="Error al crear el usuario";
            header("Location:index.php");
            die;
        }        
    }
    
?>