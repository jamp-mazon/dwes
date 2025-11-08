<?php
session_start();
require_once __DIR__."/../models/baseDatos.php";
require_once __DIR__."/../models/libro.php";
$sql="SELECT * FROM libros";
$dbInstancia=BaseDatos::getInstance();
$sentencia=$dbInstancia->get_data($sql);
$lista_libros=$sentencia->fetchAll(PDO::FETCH_OBJ);
$primer_libro=$lista_libros[0];//para pintar los th dinamicamente me cojo el primer libro e imprimo sus claves

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer - CRUD PHP</title>
    <style>
        body{
            
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color:cornsilk;
        }
        table td {
            border: 1px solid orange;
            text-align: center;
            padding: 1.3rem;
        }
        table a{
            
            border-radius: .5rem;
            color: white;
            background-color: orange;
            padding: 1rem;
            text-decoration: none;
        }
        table button {
            margin-top: 20px;
            border-radius: .5rem;
            color: white;
            background-color: red;
            padding: 1rem;
            text-decoration: none;
            cursor: pointer;
        }
    </style>    
</head>
<body>
    <table border="3">
        <thead>
            <tr>
                <?php foreach ($primer_libro as $key => $value):?>
                    <th><?=$key?></th>
                <?php endforeach; ?>
                <th>ACCION</th>    
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($lista_libros as $libro): ?>
                    <tr>
                        <?php foreach ($libro as $valor):?>
                            <td><?=$valor?></td>
                        <?php endforeach; ?>
                        <td>
                            <a class="button" href="actualizar.php?id=<?=$libro->id ?>">Actualizar</a>
                            <br>
                            <form action="procesar_borrado" method="post">
                                <input type="hidden" name="id_borrar" value="<?=$libro->id?>">
                                <button class="button" type="submit">BORRAR</button>
                            </form>
                        </td>
                        <?php endforeach; ?>        
            </tr>
        </tbody>
    </table>
</body>
</html>
