<?php 
session_start();

if (!isset($_COOKIE["pagina"])) {
    $pagina=1;
    setcookie("pagina",$pagina,time()+3600,"/");
}
else{
    $pagina=$_COOKIE["pagina"];
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["boton"])) {
        $boton=$_POST["boton"];
        if ($boton==="siguiente") {
            if ($pagina<6) {
                ++$pagina;
            }
        }
        elseif ($boton==="anterior") {
            if ($pagina>0) {
                --$pagina;
            }
        }
        else{
            setcookie("pagina","",time()-3600,"/");
            header("Location:index.php");
            die;
        }
        setcookie("pagina",$pagina,time()+3600,"/");
    }     
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historieta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="viñeta">
    <?php if ($pagina===1): ?>
    <img src="./img/1.png" alt="Image 1" width="500px">
    <?php endif; ?>
</div>
<div class="viñeta">
    <?php if ($pagina===2): ?>
    <img src="./img/2.png" alt="Image 1" width="500px">
    <?php endif; ?>
</div>
<div class="viñeta">
    <?php if ($pagina===3): ?>
    <img src="./img/3.png" alt="Image 1" width="500px">
    <?php endif; ?>
</div>
<div class="viñeta">
    <?php if ($pagina===4): ?>
    <img src="./img/4.png" alt="Image 1" width="500px">
    <?php endif; ?>
</div>
<div class="viñeta">
    <?php if ($pagina===5): ?>
    <img src="./img/5.png" alt="Image 1" width="500px">
    <?php endif; ?>
</div>
<div class="viñeta">
    <?php if ($pagina===6): ?>
    <img src="./img/6.png" alt="Image 1" width="500px">
    <?php endif; ?>
</div>
<form action="" method="post">
<div style="text-align: center;">
    <button class="movimiento" name="boton" value="anterior" type="submit"<?php echo ($pagina===1)?"disabled":""?>>⬅️ Anterior</button>
    <button class="movimiento" name="boton" value="siguiente" type="submit"<?php echo ($pagina===6)?"disabled":""?>>Siguiente ➡️</button>
</div>
<button class="movimiento" name="boton" value="inicio" type="submit">INICIO</button>
</form>

</body>
</html>