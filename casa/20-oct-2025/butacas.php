<?php
session_start();
include_once "funciones/utilidades.php";
print(error_log("ERRORES"));

if (isset($_GET["titulo"])) {
    //si viaja el titulo por el titulo cojo el titulo y la pelicula.
    $titulo=trim(htmlspecialchars(strip_tags($_GET["titulo"])));
    $pelicula=devolverPelicula($titulo);
}
elseif (isset($_POST["titulo"])) {
    $titulo=trim(htmlspecialchars(strip_tags($_POST["titulo"])));
    $pelicula=devolverPelicula($titulo);
}
else{//esta linea ya me sirve para saber si se no se hace post o get y lo redirijo a cartelera
    $_SESSION["errores"]=[];
    $_SESSION["errores"][]="Algo fallo al mostrar los detalles, vuelve a intentarlo mas tarde.";
    header("Location:cartelera.php");
    die;
}
$filas=3;
$columnas=4;
if (isset($_SERVER["REQUEST_METHOD"])=="POST") {
    if (!isset($_SESSION["butacas"])) {//si no existe session butacas
            $_SESSION["butacas"]=[];//me creo el array de las butacas vacias
            for ($i=1; $i <=$filas; $i++) { 
                for ($j=1; $j <=$columnas; $j++) { 
                        $_SESSION["butacas"][$i][$j]=0;//las rellenamos a 0;
                }
            }
    }
    else{//si existe session butacas lo que hago es cambiar los valores si antes esa fila y columna valia 0 ahora valdra 1 y viceversa
        $fila= $_POST["fila_seleccionada"] ?? "";
        $columna=$_POST["columna_seleccionada"]?? "";
        if (!empty($fila) && !empty($columna)) {//si fila y columna al momento de recogerlos no estan vacios
            if ($_SESSION["butacas"][$fila][$columna]==0) {
                $_SESSION["butacas"][$fila][$columna]=1;
            }
            else{
                $_SESSION["butacas"][$fila][$columna]=0;
            }
        }
        else{
            $_SESSION["errores"]=[];
            $_SESSION["errores"]="Error al recoger la fila y la columna";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butacas</title>
    <link rel="stylesheet" href="estilos_butacas.css">
</head>
<body>

<h1>🎥 Vista de Butacas del Cine</h1>

<div class="pantalla"><?=$pelicula->titulo?></div>

<!-- Formulario único -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="formButacas">
<!-- aqui iran dos inputs escondidos con los valores marcados -->
 <input type="hidden" name="fila_seleccionada" id="fila_seleccionada">
 <input type="hidden" name="columna_seleccionada" id=columna_seleccionada>
 <input type="hidden" name="titulo" value="<?=$titulo?>"><!--Recojo el titulo del get para poder guardarlo en el post -->
</form>

<div class="sala">
    <!-- Dentro de la sala iran las butacas ya que al pincharla el form se activaria por el evento en js -->
     <?php for ($f=1; $f <=$filas; $f++) : ?>
        <?php for ($c=1; $c <=$columnas; $c++): ?>
            <?php if ($_SESSION["butacas"][$f][$c]==0): ?>
                <img src="assets/images/imagenes_butacas/asiento-libre.png" class="butaca" data-fila="<?=$f?>" data-columna="<?=$c?>" alt="asiento-libre">
            <?php endif; ?>
            <?php if ($_SESSION["butacas"][$f][$c]==1):?>
                <img src="assets/images/imagenes_butacas/asiento-ocupado.png" class="butaca" data-fila="<?=$f?>" data-columna="<?=$c?>"alt="asiento-ocupado">
            <?php endif; ?>
        <?php endfor; ?>
    <?php endfor; ?>                
</div>

<script>
// Al hacer clic en una imagen, guarda el número y envía el formulario. 
// Vamos a usar DATASET. Para ello, en las imagenes incluifremos el 
// atributo 'data-fila' y 'data-columna'

document.querySelectorAll('.butaca').forEach(butaca => {
  butaca.addEventListener('click', () => {
    const fila = butaca.dataset.fila;
    const columna = butaca.dataset.columna;

    console.log("fila:"+fila);
    console.log("columna:"+columna);
        
    //Asignamos a los campos input hidden el valor
    document.getElementById('fila_seleccionada').value = fila;
    document.getElementById('columna_seleccionada').value = columna;
    document.getElementById('formButacas').submit();
  });
});
</script>

<div class="leyenda">
  <div class="cuadro" style="background-color:red;"></div> Libre
  <div class="cuadro" style="background-color:yellow; margin-left:15px;"></div> Ocupada
</div>

<h2>PRECIO TOTAL:  €</h2>

<?php

  //----depuracion------
  // print ("<pre>");
  // // print("Butaca pulsada:<br>");
  // // print_r($_POST); 
  // // print ("<hr>");

  // print_r($_SESSION); 
  // print("</pre>");
  //------fin depura------      
?>

</body>
</html>