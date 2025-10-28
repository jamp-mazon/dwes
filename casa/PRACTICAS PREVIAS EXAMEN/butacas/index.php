
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butacas</title>
    <link rel="stylesheet" href="">
</head>
<body>

<h1>🎥 Vista de Butacas del Cine</h1>

<div class="pantalla">PANTALLA</div>

<!-- Formulario único -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="formButacas">
  
</form>

<div class="sala">
  
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