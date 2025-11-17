<?php 
require __DIR__."/../../vendor/autoload.php";
use App\models\Usuarios;
use App\models\Basedatos;
session_start();

if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:index.php");
    exit;
}
else{
    $todoOK=true;
    $email=$_POST["email"]??"";
    $password=$_POST["password"]??"";
    $mibd=new Basedatos();
    if ($todoOK) {
        
        $parametros=[":email"=>$email];
        $sql="SELECT * FROM USUARIOS WHERE EMAIL=:email";
        $sentencia=$mibd->get_data($sql,$parametros);
        if ($sentencia==null) {
            $mibd->getLog()->error("Error en la obtencion del usuario en el login",["sentencia-getData"=>"procesar-login.php"]);
            header("Location:index.php");
            exit;
        }
        $registroPDO=$sentencia->fetch(PDO::FETCH_OBJ);
            if (password_verify($password,$registroPDO->password)) {
            $user=new Usuarios($registroPDO->id,$registroPDO->nombre,$registroPDO->email,$registroPDO->password,$registroPDO->fecha_registro);
            $_SESSION["logeado"]=true;
            $_SESSION["nombre"]=$user->getNombre();
            $_SESSION["id"]=$user->getId();
            header("Location:../views/listado.php");
            exit;            
        }
        else{
            $mibd->getLog()->error("Error al comprobar las contraseñas no coinciden",["contraseña"=>"procesar-login.php"]);
        }
    }
    else{
        $mibd->getLog()->error("Fallo al procesar el login",["LOGEO"=>"procesar-login.php"]);
    }
}
?>