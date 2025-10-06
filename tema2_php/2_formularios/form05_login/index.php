
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Form05</title>
</head>

<body>

    <!-- BEGIN menu.php INCLUDE -->
    <?php include "menu.php"?>
    <!-- END menu.php INCLUDE -->

    <main>
        <?php 
            $lista_usuarios=[];
            $file="data.json";//valdria bbdd/data.json
            $jsonData=file_get_contents("./bbdd/$file"); //apunto hacia bbdd
            $lista_usuarios=json_decode($jsonData); //convierto un array en los datos que estan guardados en el json.
            echo "<h2>Usuarios en la bbdd:".count($lista_usuarios)."</h2>";
        ?>
       


    </main>

    <!-- BEGIN FOOTER INCLUDE -->
    <?php include "footer.php"; ?>
    <!-- END FOOTER INCLUDE -->


</body>

</html>