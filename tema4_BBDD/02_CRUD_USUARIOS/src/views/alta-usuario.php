<?php
require_once "../models/Usuario.php";

// $usuario= new Usuario(
//     null,
//     "Dario",
//     "Cuello Miñarro",
//     "d.cuello",
//     password_hash("1234",PASSWORD_DEFAULT),
//     new DateTime("2023-10-21 00:00:00")
// );
// //MOSTRAR JSON
// echo json_encode($usuario,JSON_PRETTY_PRINT);
// $usuario->nombre="Perico";//setter
// echo "<p> Edad de {$usuario->nombre}: {$usuario->getEdad()} años </p>";
// echo "Password: {$usuario->password}";


?>
<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../controllers/procesar-alta.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre"><br>
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos"><br>
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario"><br>
        <label for="fecha_nac">Fecha Nacimiento</label>
        <input type="datetime" name="fecha_nac"><br>
        <label for="password">Contraseña</label>
        <input type="password" name="password"><br>
        <button type="submit">Enviar</button>
    </form>

<?php include "footer.php" ?>

</body>
</html>