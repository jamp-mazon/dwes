
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    
        <form class="form-login" action="../src/controllers/procesar-login.php" method="post">
            <h3>LOGIN USUARIO</h3>
            <label for="user">Email:</label>
            <input type="text" name="email">
            <label for="email">password:</label>
            <input type="password" name="password">
            <button type="submit">Enviar</button>
        </form>
</body>
</html>