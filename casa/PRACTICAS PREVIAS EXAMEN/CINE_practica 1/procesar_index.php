<?php
session_start();
include_once "includes/Usuario.php";
include_once "funciones/utilidades.php";

    if ($_SERVER["REQUEST_METHOD"]!="POST") {
        header("Location:index.php");
        die;
    }
    else{
        $_SESSION["errores"]=$_SESSION["errores"]??[];
        $_SESSION["mensajes"]=$_SESSION["mensajes"]??[];
        $todoOK=true;
        $nick=$_POST["nick"]??"";
        $email=$_POST["email"]??"";
        $password1=$_POST["password1"]??"";
        $password2=$_POST["password2"]??"";
        $sexo=$_POST["sexo"]??"";
        $categorias=$_POST["categorias"]??[];
        $todoOK=!empty($nick);
        $todoOK=!empty($email);
        $todoOK=!empty($password1);
        $todoOK=!empty($password2);
        $todoOK=!empty($sexo);
        $todoOK=!empty($categorias);
        if ($todoOK) {
            if ($password1!==$password2) {
                $_SESSION["errores"][]="las contraseñas tienen que coincidir.";
                header("Location:index.php");
                die;
            }
            //ESTO ES PARA HACERL EL STICKY FORM en el index;
            $_SESSION["nick"]=$nick;
            $_SESSION["email"]=$email;
            $_SESSION["password1"]=$password1;
            $_SESSION["password2"]=$password2;
            $_SESSION["sexo"]=$sexo;
            $_SESSION["categorias"]=$categorias;


            $imagen_perfil=$_FILES["avatar"]??"";
            if (empty($imagen_perfil)) {
                $_SESSION["errores"][]="La imagen es obligatoria";
                header("Location:index.php");
                die;
            }
            else{
                if ($_FILES["avatar"]["size"]>1000000) {
                    $_SESSION["errores"][]="La imagen es demasiado grande";
                    header("Location:index.php");
                    die;
                }
                else{
                    $nombre_imagen=$_FILES["avatar"]["name"];
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"],"assets/images/imagenes_user".$nombre_imagen)){

                        $nuevo_usuario=new Usuario($nick,$email,$password1,$sexo,$categorias,$nombre_imagen,false);
                        $ruta_bbdd="bbdd/usuarios.json";
                        $usuarios_json=file_get_contents($ruta_bbdd,FILE_USE_INCLUDE_PATH);
                        $lista_usuarios=devolver_usuarios();
                        array_push($lista_usuarios,$nuevo_usuario);
                        $usuarios_json=json_encode($lista_usuarios,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
                        file_put_contents($ruta_bbdd,$usuarios_json);
                        $_SESSION["mensajes"][]="Usuario creado con exito";
                        header("Location:cartelera.php");
                        $_SESSION["login"]=true;
                    }
                    else{
                        $_SESSION["errores"][]="Hubo un fallo al guardar la imagen";
                        header("Location:index.php");
                        die;
                    }
                    
                }
            }
        }
        else{
            $_SESSION["errores"][]="Los campos son incorrectos o estan vacios.";
        }







        //imagen
    }
    
?>