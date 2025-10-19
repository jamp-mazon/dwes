<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>INDEX REGISTRO</title>
</head>
<body>
    <header class="bg-black text-white h-20 text-center p-5">
        <h1>SUPERCINES</h1>
    </header>
    <main class="text-center">
        <form action="procesarReg.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
            <input class="bg-blue-300 m-2" type="text" name="nombre" id="nombre" required><br>
            <label for="edad">Edad</label>
            <input class="bg-blue-300 m-2" type="number" name="edad" id="edad" required><br>
            <label for="email">Email</label>
            <input class="bg-blue-300 m-2" type="email" name="email" id="email" required><br>
            <label for="password">Password</label>
            <input type="password" name="password1" id="password1" required><br>
            <label for="password2">Repitepass</label>
            <input type="password" name="password2" id="password2" required><br>
            <label for="foto">foto</label>
            <input class="bg-blue-300 m-2" type="file" name="foto" id="foto"><br>
            <hr>
        <div>
            <input type="checkbox" name="generos[]" id="generos" value="terror">Terror</input>
            <input type="checkbox" name="generos[]" id="generos" value="comedia">Comedia</input>
            <input type="checkbox" name="generos[]" id="generos" value="animacion">Animacion</input>
            <input type="checkbox" name="generos[]" id="generos" value="sci">Ciencia ficcion</input>
        </div><br>

            <label for="sexo">Hombre</label>
            <input type="radio" name="sexo" id="sexo" value="V" required>
            <label for="sexo">Mujer</label>
            <input type="radio" name="sexo" id="sexo" value="M" required>
            <br>
          

            <button class="cursor-pointer m-2 p-2 border rounded bg-blue-300" type="submit">Enviar</button>
        </form>
    </main>
    <footer class="bg-black text-white h-20 text-center p-5">
        <h2>UN FORMULARIO PARA DOMINARLOS A TODOS</h2>
    </footer>
    
</body>
</html>