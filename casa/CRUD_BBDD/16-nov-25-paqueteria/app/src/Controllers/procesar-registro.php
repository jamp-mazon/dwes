<?php 
require __DIR__ . "/../../vendor/autoload.php";
use App\Models\Basedatos;
use App\Models\Usuarios;
session_start();

if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:../../public/registro.php");
    die;
}
else{
    $_SESSION["errores"]=[];
    $todoOK=true;
    //Cojo el dato que llegue por el post si esta relleno si no se añade un false tanto al dato como todoOK 
    $nombre=$_POST["nombre"]??($todoOK=false);
    $email=$_POST["email"]??($todoOK=false);
    $contraseña=$_POST["password"]??($todoOK=false);
    $contraseña2=$_POST["password2"]??($todoOK=false);

    if (!$todoOK) {//si todo OK es falso.
        if (!$nombre) {//compruebo todos los datos para la vista del usuario.
            $_SESSION["errores"][]="El nombre no puede estar vacio";
        }
        else{
            $_SESSION["nombre"]=$nombre;
        }
        if (!$email) {
            $_SESSION["errores"][]="Fallo en el email";
        }
        else{
            $_SESSION["email"]=$email;
        }
        if (!$contraseña) {
            $_SESSION["errores"][]="Error en la contraseña";
        }
        if (!$contraseña2) {
            $_SESSION["errores"][]="Error al repetir contraseña";
        }
        header("Location:../../public/registro.php");
        die;
    }
    else{
        //si todo es correcto limpio los campos.
        $nombre=trim(htmlspecialchars(strip_tags($nombre)));
        $email=trim($email);
        $contraseña=trim($contraseña);
        $contraseña2=trim($contraseña2);
        if ($contraseña!==$contraseña2) {//compruebo las contraseñas
            $_SESSION["errores"][]="Las contraseñas no coinciden";
            header("Location:../../public/registro.php");
            die;
        }
        else{
            $mibd=new Basedatos();
            if ($mibd->getConectada()) {//pregunto a la bbdd si existe email
                if ($mibd->existeEmail($email)) {//no existe email.
                    $nuevo_usuario=new Usuarios(null,$nombre,$email,password_hash($contraseña,PASSWORD_DEFAULT),"operario");
                    if ($mibd->crear_usuario($nuevo_usuario)) {
                        header("Location:../../public/index.php");
                        die;                        
                    }
                    else{
                        $_SESSION["errores"][]="Error al crear el usuario, intentelo de nuevo mas tarde";
                        header("Location:../../public/registro.php");
                    }

                }
                else{
                    $_SESSION["errores"][]="El email ya existe,utilice otro...";
                    header("Location:../../public/registro.php");
                    die;
                }
            }
            else{
                $_SESSION["errores"][]="Fallo al conectar en la bbdd";
                $mibd->getLog()->error("Error al conectarse a la bbdd en registro",["REGISTRO"=>"procesar-registro.php"]);
            }
        }
    }

}

?>

