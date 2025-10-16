<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">k
</head>

<body>
    <header>
        <?= include "header.php" ?>
    </header>
    <main>
        <div class="formulario">
            <form action="procesar_registro.php" method="post">
                <div>
                    <label for="nick">Nick*</label>
                    <input type="text" name="nick" id="nick" required>
                </div>
                <br>
                <div>
                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <br>
                <div>
                    <label for="password1">Nueva Contraseña*</label>
                    <input type="password" name="password1" id="password1" required>
                </div>
                <div>
                    <label for="password2">Repite Contraseña</label>
                    <input type="password" name="password2" id="password2" required>
                </div>
                <br>
                <div>
                    <label for="generos">Elige tu genero*</label><br>
                    <input type="radio" name="genero" id="masculino" value="masculino">
                    <label for="masculino">Masculino</label>
                    <input type="radio" name="genero" id="femenino" value="femenino">
                    <label for="femenino">Femenino</label>
                    <input type="radio" name="genero" id="otro" value="otro">
                    <label for="otro">Otro</label><br>
                </div>
                <br>
                <div>
                    <label for="aficiones">Elige tus aficiones</label>
                    <input type="checkbox" name="aficiones[]" id="futbol" value="futbol">
                    <label for="futbol">Futbol</label>
                    <input type="checkbox" name="aficiones[]" id="humor" value="humor">
                    <label for="humor">Humor</label>
                    <input type="checkbox" name="aficiones[]" id="lectura" value="lectura">
                    <label for="lectura">Lectura</label>
                </div>
                    <button type="submit" class="boton">Enviar</button>
            </form>
        </div>
    </main>
    <footer>
        <?= include "footer.php" ?>
    </footer>
</body>

</html>