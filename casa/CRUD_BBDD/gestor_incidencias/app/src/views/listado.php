<?php
session_start();
use App\models\Basedatos;
require __DIR__ ."/../../vendor/autoload.php";
if (!$_SESSION["logueado"]) {
    header("Location:../../../public/login.php");
    die;
}
else{
    var_dump($_SESSION);
    $nombre=$_SESSION["nombre"];
    $email=$_SESSION["email"];
    $id=$_SESSION["id"];
    $rol=$_SESSION["rol"];

    $mibd=new Basedatos();
    $parametro=[];
    if ($rol==="admin") {
        $sql="SELECT * FROM incidencias";
    }
    else{
        $sql="SELECT * FROM incidencias where id_usuario=:id";
        $parametro=[":id"=>$id];
    }
    $sentencia=$mibd->get_data($sql,$parametro);
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Listado de incidencias</title>
  <link rel="stylesheet" href="incidencias.css">
</head>
<body>

  <header class="topbar">
    <div class="brand">
      <div class="logo"></div>
      <h1>Gestor de Incidencias</h1>
    </div>

    <div class="userbox">
      <div class="user-name"><?= $nombre ?></div>
      <div class="user-email"><?= $email ?></div>
      <div class="user-role"><?= $rol ?></div>
    </div>
  </header>

  <main class="container">

    <!-- Barra acciones -->
    <section class="actions">
      <div class="actions-group">
        <a href="nueva-incidencia.php" class="btn btn-primary">+ Nueva incidencia</a>
      </div>

      <div class="actions-group">
        <!-- Solo visible para admin (cuando lo conectes con PHP) -->
         <?php if ($rol==="admin"): ?>
        <a href="exportar_pdf.php" class="btn btn-warning admin-only">Exportar PDF</a>
          <?php endif; ?>
        <a href="../controllers/logOut.php" class="btn btn-dark">Cerrar sesión</a>
      </div>
    </section>

    <!-- Listado -->
    <section class="card">
      <h2>Mis incidencias</h2>
    <div class="table-wrapper">
      <table class="table">
        <thead>
          <tr>
            <th style="width:70px;">ID</th>
            <th>titulo</th>
            <th>Descripción</th>
            <!-- Solo visible para admin -->
            <th style="width:160px;" class="admin-only">Usuario</th>
            <th style="width:120px;">Estado</th>
            <?php if ($rol==="admin"): ?>            
            <th style="width:180px;">Acciones</th>
            <?php endif; ?>
          </tr> 
        </thead>
        <tbody>
            <?php while ($registroPDO=$sentencia->fetch(PDO::FETCH_OBJ)):?>
                <tr>
                    <td><?=$registroPDO->id?></td>
                    <td><?= $registroPDO->titulo ?></td>
                    <td><?= $registroPDO->descripcion ?></td>
                    <?php 
                      $sql="SELECT nombre FROM usuarios where id=:id_usuario";
                      $parametros=[":id_usuario"=>$registroPDO->id_usuario];
                      $sentencia3=$mibd->get_data($sql,$parametros);
                      $nombre_usuario=$sentencia3->fetch(PDO::FETCH_OBJ);
                    ?>
                    <td><?= $nombre_usuario->nombre ?></td>
                    <?php 
                      $resuelta="";
                      if ($registroPDO->resuelta==0) {
                          $resuelta="Incompletada";
                      }
                      else{
                        $resuelta="Completada";
                      }
                    ?>
                    <td><?= $resuelta  ?></td>
                    
                    <?php if ($rol==="admin"): ?>
                    <td>
                        <a class="btn-dark" href="resolver_incidencia.php?id=<?= $registroPDO->id ?>"><button>Resolver</button></a>
                        <a class="btn-dark" href="ver_incidencia.php?id=<?= $registroPDO->id ?>"><button>Incidencia</button></a>
                        
                    </td>
                    <?php endif; ?>   
                </tr>
            <?php endwhile; ?>
        </tbody>
      </table>
    </div>                
    </section>
  </main>
</body>
</html>
v