<?php
session_start();
$nick = (isset($_SESSION["nick"])) ? $_SESSION["nick"] : "" ;
$categoria=$_SESSION["categorias"]??[];



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
                <input type="text" name="nick" placeholder="Tu nick" value="<?php echo $nick ?>">
            </label>

            <label>Email
                <input type="email" name="email" placeholder="tucorreo@ejemplo.com" value="<?php echo $email=$_SESSION["email"]??"" ?>">
            </label>
            <label>Contraseña
                <input type="password" name="password1" placeholder="***********" value="<?php echo $password1=$_SESSION["password1"]??"" ?>">
            </label>
            <label>Repite la Contraseña
                <input type="password" name="password2" placeholder="***********"value="<?php echo $password2=$_SESSION["password2"]??"" ?>">
            </label>


            <fieldset class="inline">
                <legend>Sexo</legend>
                <label><input type="radio" name="sexo" value="masculino"<?php echo (isset($_SESSION["sexo"]) && $_SESSION["sexo"]==="masculino")? "checked": "" ?>> Masculino </label>
                <label><input type="radio" name="sexo" value="femenino" <?php echo (isset($_SESSION["sexo"]) && $_SESSION["sexo"]==="femenino")? "checked": "" ?>> Femenino</label>
                <label><input type="radio" name="sexo" value="otro" <?php echo (isset($_SESSION["sexo"]) && $_SESSION["sexo"]==="otro")? "checked": "" ?>> Otro</label>
            </fieldset>

            <fieldset class="inline">
                <legend>Categorías de cine</legend>
                <label><input type="checkbox" name="categorias[]" value="accion"<?php echo (in_array("accion",$categoria))? "checked":"" ?>> Acción</label>
                <label><input type="checkbox" name="categorias[]" value="comedia" <?php echo (in_array("comedia",$categoria))? "checked":"" ?>> Comedia</label>
                <label><input type="checkbox" name="categorias[]" value="drama" <?php echo (in_array("drama",$categoria))? "checked":"" ?>> Drama</label>
                <label><input type="checkbox" name="categorias[]" value="ciencia_ficcion" <?php echo (in_array("ciencia_ficcion",$categoria))? "checked":"" ?>> Ciencia ficción</label>
                <label><input type="checkbox" name="categorias[]" value="terror" <?php echo (in_array("terror",$categoria))? "checked":"" ?>> Terror</label>
                <label><input type="checkbox" name="categorias[]" value="animacion" <?php echo (in_array("acanimacioncion",$categoria))? "checked":"" ?>> Animación</label>
            </fieldset>

            <label>Imagen de perfil
                <input type="file" name="avatar" accept="image/*">
            </label>

            <!-- zona mensajes/errores (la poblarás con PHP) -->
            <div class="alert" <?php $hidden=(empty($_SESSION["errores"])) ? "hidden": "" ?>>
                <?php if (isset($_SESSION["errores"]) && !empty($_SESSION["errores"])): ?>
                    <?php foreach ($_SESSION["errores"] as $error): ?>
                        <p><?=$error?></p>
                    <?php endforeach; ?>
                <?php endif;?>
            </div>
            <div class="alert" <?php $hidden=(empty($_SESSION["errores"])) ? "hidden": "" ?>>
                <?php if (isset($_SESSION["mensajes"]) && !empty($_SESSION["mensajes"])): ?>
                    <?php foreach ($_SESSION["mensajes"] as $mensaje): ?>
                        <p><?=$mensaje?></p>
                    <?php endforeach; ?>
                <?php endif;?>                        
            </div>            
            <?php 
                unset($_SESSION["errores"]);
                unset($_SESSION["mensajes"]);
                unset($_SESSION["nick"]);
                unset($_SESSION["email"]);
                unset($_SESSION["password1"]);
                unset($_SESSION["password2"]);
                unset($_SESSION["sexo"]);
                unset($_SESSION["categorias"]);

            ?>
            <button type="submit" class="btn">Registrarme</button>
        </form>
    </main>
</body>

</html>