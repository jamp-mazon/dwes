
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
                <input type="text" name="nick" placeholder="Tu nick">
            </label>

            <label>Email
                <input type="email" name="email" placeholder="tucorreo@ejemplo.com">
            </label>
            <label>Contraseña
                <input type="password" name="password1" placeholder="***********">
            </label>
            <label>Repite la Contraseña
                <input type="password" name="password2" placeholder="***********">
            </label>


            <fieldset class="inline">
                <legend>Sexo</legend>
                <label><input type="radio" name="sexo" value="masculino"> Masculino</label>
                <label><input type="radio" name="sexo" value="femenino"> Femenino</label>
                <label><input type="radio" name="sexo" value="otro"> Otro</label>
            </fieldset>

            <fieldset class="inline">
                <legend>Categorías de cine</legend>
                <label><input type="checkbox" name="categorias[]" value="accion"> Acción</label>
                <label><input type="checkbox" name="categorias[]" value="comedia"> Comedia</label>
                <label><input type="checkbox" name="categorias[]" value="drama"> Drama</label>
                <label><input type="checkbox" name="categorias[]" value="ciencia_ficcion"> Ciencia ficción</label>
                <label><input type="checkbox" name="categorias[]" value="terror"> Terror</label>
                <label><input type="checkbox" name="categorias[]" value="animacion"> Animación</label>
            </fieldset>

            <label>Imagen de perfil
                <input type="file" name="avatar" accept="image/*">
            </label>

            <!-- zona mensajes/errores (la poblarás con PHP) -->
            <div class="alert" hidden>
                <p>• Aquí aparecerán los errores del formulario.</p>
            </div>

            <button type="submit" class="btn">Registrarme</button>
        </form>
    </main>
</body>

</html>