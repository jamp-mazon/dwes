<?php
session_start();
require_once "../models/basedatos.php";

if (!isset($_SESSION["conectado"]) || !$_SESSION["conectado"]) {
    header("Location:../../public/index.php");
    die;
}

$dbInstacia=BaseDatos::getInstance();//por singleton


$sql="SELECT * FROM usuarios";

$sentencia= $dbInstacia->get_data($sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD USUARIOS</title>
</head>
<body>
    <?php include "menu.php"; ?>
    <h1>LISTADO DE USUARIOS</h1>
    <table border="3" class="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Fecha Nac</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($registroPDO = $sentencia->fetch(PDO::FETCH_OBJ)):?>
                <tr>
                    <td><?=$registroPDO->nombre ?></td>
                    <td><?=$registroPDO->apellidos ?></td>
                    <td><?=$registroPDO->usuario ?></td>
                    <td><?=$registroPDO->fecha_nac ?></td>
                    <td>
                        <a href="ver.php?id=<?=$registroPDO->id?>">
                            <button>VER</button>
                        </a>
                    <form action="borrar.php" method="post">
                        <input type="hidden" name="id_a_borrar" value="<?=$registroPDO->id?>">
                        <button type="submit">BORRAR</button>
                    </form>
                    <form action="actualizar.php" method="post">
                        <input type="hidden" name="id_a_actualizar" value="<?=$registroPDO->id?>">
                        <button type="submit">ACTUALIZAR</button>
                    </form>    
                    
                </td>

                </tr>
            <?php endwhile; ?>    
        </tbody>
    </table>
</body>
</html>