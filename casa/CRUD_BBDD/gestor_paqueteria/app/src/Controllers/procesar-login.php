<?php 
session_start();
require __DIR__ . "/../../vendor/autoload.php";
use App\Models\Basedatos;
use App\Models\Usuarios;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../../public/index.php");
    die;
}
else{
    $_SESSION["errores"]=[];
    $todoOK=true;
    $email=$_POST["email"]??($todoOK=false);
    $password=$_POST["password"]??($todoOK=false);
    if (!$todoOK) {
        if (!$email) {
            $_SESSION["errores"][]="Error en el formato del Email";
        }
        if (!$password) {
            $_SESSION["password"][]="Error en el formato de la contraseña";
        }
        header("Location:../../public/index.php");
        die;
    }
    else{
        $email=trim(htmlspecialchars($email));
        $mibd=new Basedatos();
        if ($mibd->existeEmail($email)){
            $_SESSION["errores"][]="Error en campo email:ese Email no existe";
            header("Location:../../public/index.php");
            die;
        }
        else{
            $parametros=[":email"=>$email];
            $sql="SELECT * FROM usuarios WHERE email=:email ";
            $sentencia=$mibd->get_data($sql,$parametros);
            if (!$sentencia) {
                $_SESSION["errores"][]="Algo ha fallado, intentalo de nuevo mas tarde...";
                $mibd->getLog()->error("Error:la sentencia ha devuelto null al recoger email y password",["Devolver Usuario"=>"procesar-login.php"]);
                header("Location:../../public/index.php");
                die;
            }
            else{
                $registroPDO=$sentencia->fetch(PDO::FETCH_OBJ);
                if (!$registroPDO) {
                    $_SESSION["errores"][]="La consulta no arrojo resultados...Intentelo mas tarde";
                    $mibd->getLog()->error("El registro esta vacio o no devuelve resultados",["registro-PDO"=>"procesar-login.php"]);
                    header("Location:../../public/index.php");
                    die;
                }
                else{
                    $nuevo_usuario=new Usuarios(
                        $registroPDO->id,
                        $registroPDO->nombre,
                        $registroPDO->email,
                        $registroPDO->password_hash,
                        $registroPDO->rol,
                        $registroPDO->creado_en
                    );
                    //compruebo la password en texto plano y hasheada si es OK el usuario se logea con exito
                    if (password_verify($password,$nuevo_usuario->getPassword())) {
                        $_SESSION["id"]=$nuevo_usuario->getId();
                        $_SESSION["logeado"]=true;
                        header("Location:../views/dashboard.php");
                        die;
                    }
                    else{
                        $mibd->getLog()->error("Error al verificar la contraseña",["password_verify"=>"procesar-login.php"]);
                        header("Location:../../public/index.php");
                        die;
                    }
                }

            }
            

        }
    }
}
?>
