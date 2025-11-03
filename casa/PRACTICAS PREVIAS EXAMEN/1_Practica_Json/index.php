<?php
session_start();
$lista_user=[];
$ruta="usuarios.json";
$usuarios_json=file_get_contents($ruta,FILE_USE_INCLUDE_PATH);
$lista_user=json_decode($usuarios_json,true);//hago array asociativo y en teoria lo tengo;
print("<pre>");
print_r($lista_user);
print("</pre>");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color: darkkhaki;">

    <table border="3">
        <thead>
            <tr>
                <?php foreach ($lista_user as $usuario) : ?>
                    <?php foreach ($usuario[0] as $llave =>$valor): ?>
                        <th><?=$llave ?></th>
                    <?php endforeach; ?>
                <?php endforeach;?>        
            </tr>
        </thead>
        <tbody>
                <?php foreach ($lista_user as $usuario) : ?>
                    <?php foreach ($usuario as $indice=>$clave): ?> 
                        <tr></tr>
                        <?php foreach ($clave as $valor): ?>
                             <td><?=$valor?></td>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach;?>
        </tbody>
    </table>
</body>
</html>