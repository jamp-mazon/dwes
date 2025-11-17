<?php 
require __DIR__ . "/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\Tarea;
session_start();
        // $_SESSION["logeado"]=true;
        // $_SESSION["nombre"]=$user->getNombre();
        // $_SESSION["id"]=$user->getId();
if ($_SESSION["logeado"] && isset($_SESSION["nombre"]) && isset($_SESSION["id"])) {
   // var_dump($_SESSION);
    $mibd=new Basedatos();
    $parametros=[":usuario_id"=>$_SESSION["id"]];
    $sql = "SELECT tareas.id AS tarea_id,
               tareas.usuario_id,
               tareas.descripcion,
               tareas.completada
        FROM tareas
        WHERE tareas.usuario_id = :usuario_id";
    $sentencia=$mibd->get_data($sql,$parametros);   
}
else{
    header("Location:../../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDO</title>
     <link rel="stylesheet" href="../../public/css/estilos.css">
</head>
<body>
    <h1>LISTADO DE TAREAS:<span><?= $_SESSION["nombre"] ?></span></h1>

    <form action="../controllers/procesar-add.php" method="POST" class="form-add">
        <input type="text" name="descripcion" placeholder="Nueva tarea..." required>
        <input type="hidden" name="id_usuario" value="<?=$_SESSION["id"]?>">
        <button type="submit">Añadir</button>
    </form>

    <ul class="task-list"><?php 
            while ($registroPDO = $sentencia->fetch(PDO::FETCH_OBJ)):
            // echo "<p>BOOLEANO(REGISTRO):".$registroPDO->completada."</p>";

                $t=new Tarea(
                    $registroPDO->tarea_id,
                    $registroPDO->usuario_id,                    
                    $registroPDO->descripcion,
                    $registroPDO->completada,
                );
        ?>
        <!-- <p>BOOLEANO(TAREA):<?= $t->getCompletada() ?></p> -->
        <li class="<?= $t->getCompletada() ? 'done' : '' ?>">
            <?= ($t->getDescripcion()) ?>

            
                <form action="../controllers/procesar-actualizar.php" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $t->getId() ?>">
                    <input type="hidden" name="estado" value="<?= $t->getCompletada() ? '1' : '0' ?>">
                    <button type="submit">✔</button>
                </form>
            

            <form action="../controllers/procesar-borrar.php" method="POST" class="inline">
                <input type="hidden" name="id" value="<?= $t->getId() ?>">
                <button type="submit">🗑️</button>
            </form>
        </li>
    <?php endwhile; ?>
    </ul>
    <form action="../controllers/procesar-pdf.php" method="post">
        <input type="hidden" name="id" value="<?= $_SESSION["id"] ?>">
        <button type="submit" name="pdf">PDF</button>
    </form>
    <form action="../controllers/logOut.php" method="post">
        <button type="submit">Cerrar Sesion</button>
    </form>
</body>
</html>