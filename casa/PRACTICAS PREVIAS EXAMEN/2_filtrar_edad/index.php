<?php 
$usuarios=[];
$ruta="usuarios.json";
$usuario_json=file_get_contents($ruta,FILE_USE_INCLUDE_PATH);
$array_user=json_decode($usuario_json,true);
$usuarios=$array_user["usuarios"];
// print "<pre>";
// print_r($array_user);
// print "</pre>";
// print "<hr>";
// print "<pre>";
// print_r($usuarios);
// print "</pre>";
$edad_a_buscar=($_GET["edad"])??0;
$usuarios_filtrados=[];
$hayUsuarios=false;
foreach ($usuarios as $usuario) {
    if ($usuario["edad"]>=$edad_a_buscar) {
        array_push($usuarios_filtrados,$usuario);
    }
}
if (!empty($usuarios_filtrados)) {
    $hayUsuarios=true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Filtrar usuarios</title>
</head>
<body style="background-color: lightblue;">
  <h2>Usuarios con edad mínima: </h2>

  <ul>
    <!-- Aquí irán los <li> con los usuarios filtrados -->
    <?php if ($hayUsuarios): ?>
        <?php foreach ($usuarios_filtrados as $usuario ):  ?>
                <li><?php echo "$usuario[nombre] || $usuario[edad]" ?></li>
        <?php endforeach; ?>
    <?php endif; ?>        

  </ul>
<form method="get" action="">
  <label>Edad mínima:</label>
  <input type="number" name="edad">
  <button type="submit">Filtrar</button>
</form>
  <?php if (!$hayUsuarios): ?>
  <p>No se encontraron usuarios con esa edad mínima.</p>
  <?php endif; ?>
</body>
</html>
