<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include_once "funciones/funciones.php";
include_once "usuario.php";

    if($_SERVER['REQUEST_METHOD']!="POST"){
        header("Location: index.php");
        die;
    }else{
        //validaciones
        $_SESSION['errores']=[];
        $nombreOK=false; $edadOK=false; $emailOK=false; $sexoOK=false; $passwordOK=false;
        $fotoOK=false;

        $nombre=recogerDato('nombre');
        if($nombre==null){
            $errorNombre="algo ha ido mal al introducir el nombre";
            array_push($_SESSION['errores'],$errorNombre);
            header("Location:index.php");
            die;
        }else{
            $nombreOK=true;
        }
        
        $edad=recogerDato('edad');
        if($edad==null){
            $errorEdad="algo ha ido mal al introducir la fecha";
            array_push($_SESSION['errores'],$errorEdad);
            header("Location:index.php");
            die;
        }else{
            $edadOK=true;
        }

        $email=recogerEmail('email');
        if($email==null){
            $errorEmail="algo ha ido mal al introducir el email";
            array_push($_SESSION['errores'],$errorEmail);
            header("Location:index.php");
            die;
        }else{
            if (existe_email($email)) {
                $errorEmail="Ese email ya esta registrado...";
                array_push($_SESSION['errores'],$errorEmail);
                header("Location:index.php");
                die;
            }
            else{
                $emailOK=true;
            }
            
        }

        $sexo=recogerDato('sexo');
        if($sexo==null){
            $errorSexo="es necesario escoger un genero";
            array_push($_SESSION['errores'],$errorSexo);
            header("Location:index.php");
            die;
        }else{
            $sexoOK=true;
        }
        
        if(isset($_POST['password1']) && $_POST['password1']!=""){
            if($_POST['password1']==$_POST['password2']){
                $password=$_POST['password1'];
                $passwordOK=true;
            }else{
                $errorPass="contraseñas no coinciden";
                array_push($_SESSION['errores'],$errorPass);
                header("Location:index.php");
                die;
            }
        }

        $generos=[];
        if(isset($_POST['generos']) && $_POST['generos']!=""){
            $generos=$_POST['generos'];
        }

        if($_FILES['foto']['size'] > 2000000){
            $errorFoto="archivo demasiado grande";
            array_push($_SESSION['errores'], $errorFoto);
            header("Location:index.php");
            die;
        }else{
            $ruta="assets/";
            $subir=move_uploaded_file($_FILES['foto']['tmp_name'], $ruta.$_FILES['foto']['name']);
            $foto=$_FILES['foto']['name'];
        }
        if($foto==null){
            $errorFoto2="algo ha ido mal al subir el archivo";
            array_push($_SESSION['errores'],$errorFoto2);
            header("Location:index.php");
            die;
        }else{
            $fotoOK=true;
        }

        if($nombreOK && $sexoOK && $fotoOK && $passwordOK && $edadOK && $emailOK){
            $nuevoUsu = new Usuario($nombre, $edad, $email, $password, $generos, $sexo);

            // Ruta absoluta al JSON para evitar problemas de paths relativos
            $ruta = __DIR__ . "/bbdd/data.json";

            // Leer y decodificar, manejando archivo vacío o contenido inválido
            $data = @file_get_contents($ruta);
            $listaUsuarios = @json_decode($data, true);
            if (!is_array($listaUsuarios)) {
                $listaUsuarios = [];
            }

            // Añadir el nuevo usuario (el objeto implementa JsonSerializable)
            $listaUsuarios[] = $nuevoUsu;

            // Codificar y escribir con bloqueo
            $jsonSalida = json_encode($listaUsuarios, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            if ($jsonSalida === false) {
                $_SESSION['errores'][] = 'Error al codificar los datos del usuario.';
                header('Location: index.php');
                die;
            }

            $escrito = @file_put_contents($ruta, $jsonSalida, LOCK_EX);
            if ($escrito === false) {
                $_SESSION['errores'][] = 'No se pudo guardar el usuario (permiso denegado o ruta incorrecta).';
                header('Location: index.php');
                die;
            }

            $_SESSION["mensajes"]["usuario"] = "Usuario creado con exito!!";
            header("Location:login.php");
            exit;
        }
        else{
            $errorUsuario="Algo fallo al crear el usuario";
            array_push($_SESSION["errores"],$errorUsuario);
            header("Location:index.php");
            die;
        }


    }

?>