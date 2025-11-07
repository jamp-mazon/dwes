<?php
require_once "../models/basedatos.php";
require_once "../models/Usuario.php";

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:listado.php");
    die;
}
else{
    $id=$_POST["id_a_actualizar"];
    $dbIntancia=BaseDatos::getInstance();
    $sql="SELECT * FROM usuarios where id=$id";
    $sentencia=$dbIntancia->get_data($sql);
    $registro_usuario=$sentencia->fetch(PDO::FETCH_OBJ);


    $usuario=new Usuario(
        $registro_usuario->id,
        $registro_usuario->nombre,
        $registro_usuario->apellidos,
        $registro_usuario->usuario,
        $registro_usuario->password,
        new DateTime($registro_usuario->fecha_nac)
    );

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../controllers/actualizar.php" method="post">
        <input type="hidden" name="id" value="<?=$usuario->id ?>">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?=$usuario->nombre ?>"><br>
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" value="<?=$usuario->apellidos ?>"><br>
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" value="<?=$usuario->usuario ?>"><br>
        <label for="fecha_nac">Fecha Nacimiento</label>
        <input type="date" name="fecha_nac" value="<?= $usuario->fecha_nac->format("Y-m-d")?>"><br>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" value="<?=$usuario->password ?>" disabled > <button id="activar">Activar</button><br>
        <button type="submit">Enviar</button>
        <script>
            
            let btn_activar=document.getElementById("activar");
            let password=document.getElementById("password");
            btn_activar.addEventListener("click",function () {
                event.preventDefault();
                password.disabled = !password.disabled;
            });

        </script>
    </form>    
</body>
</html>