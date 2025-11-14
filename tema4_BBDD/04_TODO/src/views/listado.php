<?php 
session_start();
require __DIR__."/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\Tarea;
if (!$_SESSION["conectado"]) {
    header("Location:../../public/index.php");
    die;
}
else{
    $midb = new Basedatos();
    $sql = "SELECT * FROM tareas";
    $sentencia = $midb->get_data($sql);
    if ($sentencia == null) {
        echo "ERROR EN LA CONSULTA";
        die;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDO</title>
     <link rel="stylesheet" href="./../../public/css/styles.css">
</head>
<body>
    <h1>LISTADO DE TAREAS</h1>

    <form action="../controllers/procesar_add.php" method="POST" class="form-add">
        <input type="text" name="descripcion" placeholder="Nueva tarea..." required>
        <button type="submit">Añadir</button>
    </form>

    <ul class="task-list">
        <?php  
            while ($registroPDO=$sentencia->fetch(PDO::FETCH_OBJ)):
                $t=new Tarea(
                $registroPDO->id,
                $registroPDO->descripcion,
                $registroPDO->completada
                );
        ?>
        <li class="<?= $t->getCompletada() ? 'done' : '' ?>">
            <?= ($t->getDescripcion()) ?>

           
                <form action="../controllers/procesar_completada.php" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $t->getId() ?>">
                    <button type="submit">✔</button>
                </form>
              

            <form action="../controllers/procesar_borrar.php" method="POST" class="inline">
                <input type="hidden" name="id" value="<?= $t->getId() ?>">
                <button type="submit">🗑️</button>
            </form>
        </li>
   <?php endwhile; ?>
    </ul>
    
</body>
</html>
