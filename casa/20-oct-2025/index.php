
<?php session_start();
//metemos los posibles errores en variables y los correctos paraq hacer el sticky-FORM
// if (isset($_SESSION["nick"])) {
//     $nick=$_SESSION["nick"];
// }
// else{
//     if (isset($_SESSION["errores"]["nick"])) {
//         $nick_error=$_SESSION["errores"]["nick"];
//     }
// }
?>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CINE · Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body class="bg">
    <header class="hdr">
        <h1>CINE · Registro</h1>
        <nav><a href="login.php" class="btn-sec">Ya estoy registrado</a></nav>
    </header>

    <main class="container">
        <form class="card" action="procesar_index.php" method="post" enctype="multipart/form-data">
            <h2>Crear cuenta</h2>

            <label>Nick
                <input type="text" name="nick" placeholder="Tu nick" value="<?php echo $_SESSION["nick"]??  "";?>">
            </label>
            <label>Email
                <input type="text" name="email" placeholder="tucorreo@ejemplo.com" value="<?php echo $_SESSION["email"]?? ""; ?>">
            </label>
            <label>Contraseña
                <input type="password" name="password1" placeholder="***********">
            </label>
            <label>Repite la Contraseña
                <input type="password" name="password2" placeholder="***********">
            </label>


            <fieldset class="inline">
                <legend>Sexo</legend>
                <label><input type="radio" name="sexo" value="m"> Masculino <?php echo $sexo = (isset($_SESSION["sexo"]) && $_SESSION["sexo"]==="m") ? "checked" : "" ;?> </label>
                <label><input type="radio" name="sexo" value="f"> Femenino <?php echo $sexo = (isset($_SESSION["sexo"]) && $_SESSION["sexo"]==="f") ? "checked" : "" ;?></label>
                <label><input type="radio" name="sexo" value="o"> Otro <?php echo $sexo = (isset($_SESSION["sexo"]) && $_SESSION["sexo"]==="o") ? "checked" : "" ;?></label>
            </fieldset>

            <fieldset class="inline">
                <legend>Categorías de cine</legend>
                <label><input type="checkbox" name="categorias[]" value="accion"<?php echo $categoria = (isset($_SESSION["categorias"]) && in_array("accion",$_SESSION["categorias"])) ? "checked" : "" ;?> > Acción</label>
                <label><input type="checkbox" name="categorias[]" value="comedia"<?php echo $categoria = (isset($_SESSION["categorias"]) && in_array("comedia",$_SESSION["categorias"])) ? "checked" : "" ;?> > Comedia</label>
                <label><input type="checkbox" name="categorias[]" value="drama"<?php echo $categoria = (isset($_SESSION["categorias"]) && in_array("drama",$_SESSION["categorias"])) ? "checked" : "" ;?>> Drama</label>
                <label><input type="checkbox" name="categorias[]" value="ciencia_ficcion"<?php echo $categoria = (isset($_SESSION["categorias"]) && in_array("ciencia_ficcion",$_SESSION["categorias"])) ? "checked" : "" ;?>> Ciencia ficción</label>
                <label><input type="checkbox" name="categorias[]" value="terror" <?php echo $categoria = (isset($_SESSION["categorias"]) && in_array("terror",$_SESSION["categorias"])) ? "checked" : "" ;?>> Terror</label>
                <label><input type="checkbox" name="categorias[]" value="animacion" <?php echo $categoria = (isset($_SESSION["categorias"]) && in_array("animacion",$_SESSION["categorias"])) ? "checked" : "" ;?>> Animación</label>
            </fieldset>

            <label>Imagen de perfil
                <input type="file" name="avatar" accept="image/*">
            </label>

            <!-- zona mensajes/errores (la poblarás con PHP) -->
            <div class="alert">
                <?php
                    if (isset($_SESSION["errores"])) {
                        foreach ($_SESSION["errores"] as $error) {
                            echo "<p class='error'>$error</p>";
                        }
                    }
                    unset($_SESSION["errores"]);
                ?>
            </div>

            <button type="submit" class="btn">Registrarme</button>
        </form>
    </main>
</body>

</html>