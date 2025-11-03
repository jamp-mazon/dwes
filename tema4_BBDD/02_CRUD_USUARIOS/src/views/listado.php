<?php
session_start();
if (!isset($_SESSION["conectado"]) || !$_SESSION["conectado"]) {
    header("Location:../../public/index.php");
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD USUARIOS</title>
</head>
<body>
    <h1>LISTADO DE USUARIOS</h1>
</body>
</html>