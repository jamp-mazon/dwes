<?php
session_start();

if (!isset($_COOKIE["visita"])) {
    $visita=1;
    setcookie("visita",$visita,time()+(7*24*60*60),"/");
}
else{
    $visita=$_COOKIE["visita"];
    setcookie("visita",++$visita,time()+(7*24*60*60),"/");
}
// if (isset($_GET["reset"])) {
//     setcookie("visita",$_GET["reset"],time()-3600,"/");
// }
echo $visita
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Contador de visitas</title>
</head>
<body style="background-color: #f2f2f2; font-family: Arial; text-align: center; margin-top: 50px;">
  <h2><?= htmlspecialchars($visita) ?></h2>

  <p>¿Quieres reiniciar el contador?</p>

  <!-- 🔽 Este form envía por GET para reiniciar -->
  <form method="get" action="">
    <button type="submit" name="reset" value="1">Reiniciar contador</button>
  </form>
</body>
</html>