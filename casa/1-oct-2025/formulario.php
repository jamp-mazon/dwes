<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["nombre"]) && isset($_POST["nombre"]!="")) {
        $nombre=trim(htmlspecialchars(strip_tags($_POST["nombre"])));
    }
    else{
        $nombreError="Nombre incorrecto , pruebe con otro nombre.";
    }
    if(isset($_POST["apellidos"]) && isset($_POST["apellidos"]!="")){
        $apellidos=trim(htmlspecialchars(strip_tags($_POST["apellidos"])));
    }
    else{
        $edadError="formato de apellidos incorrecto, pruebe de otra forma"
    }
    if (isset($_POST["email"]) && filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $email=trim(htmlspecialchars(strip_tags($_POST["email"])));

    } else {
        $emailError="Email incorrecto"
    }
    
} else {
    # code...
}


?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Probando php</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-blue-200">
    <header class="bg-black text-white p-3 text-center">
        <h1>FORMULARIO SUPER WAPO</h1>
    </header>
    <main class=" text-center mt-4">
        <article class="bg-lime-200 border max-w-sm m-auto mb-4 ">
        <div class="">
            <form action="formulario.php" method="post">
                <div class="p-4">
                    <p>
                        
                        <label class="ml-2" for="nombre">Nombre:</label>
                        <input class="border mt-1 bg-white" type="text" name="nombre" id="nombre">
                    </p>
                    <p>
                        
                        <label for="apellidos">Apellidos:</label>
                        <input class="border mt-2 bg-white" type="text" name="apellidos" id="apellidos">
                    </p>
                    <p>
                        
                        <label class="ml-7"for="email">email:</label>
                        <input class="border mt-2 bg-white" type="text" name="email" id="email">

                    </p>

                    <p class="mt-2">
                        <input type="radio" name="sexo" id="sexo_masculino">
                        <label for="sexo_masculino">MASCULINO</label>
                        <input type="radio" name="sexo" id="sexo_femenino">
                        <label for="sexo_femenino">FEMENINO</label>
                    </p>
                    <div class="mt-2">
                        <input class="ml-5" type="checkbox" name="aficiones[]" value="Musica">Musica</input><br>
                        <input type="checkbox" name="aficiones[]" value="Cine">Cine</input><br>
                        <input class="ml-6"type="checkbox" name="aficiones[]" value="Lectura">Lectura</input><br>
                    </div>
                    <button class="mt-2 bg-blue-600 p-1 rounded text-white cursor-pointer hover:bg-blue-900" type="submit">Enviar</button>
                </div>
            </form>
        </article>
    </div>
    </main>
    <footer class="bg-black text-white p-3 text-center">
        <h2>Creado por Guillermo y Mazón. Todos los derechos reservados</h2>
    </footer>
</body>
</html>