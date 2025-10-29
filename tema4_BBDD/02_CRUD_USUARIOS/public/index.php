<?php
session_start();

require_once __DIR__."/../src/models/basedatos.php";

//Nos conectamos a la base de datos
$dbInstancia= BaseDatos::getInstance();//singleton

?>