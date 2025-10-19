<?php
session_start();
    $filas = 3;
    $columnas = 4;

    if (empty($_SESSION["butacas"])) {
        $_SESSION["butacas"] = [];
        for ($f = 1; $f <= $filas; $f++) {
            for ($c = 1; $c <= $columnas; $c++) {
                $_SESSION["butacas"][$f][$c]=0;
            }
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fila=$_POST["fila_seleccionada"];
        $columna=$_POST["columna_seleccionada"];

        if ($_SESSION["butacas"][$fila][$columna]==0) {
            $_SESSION["butacas"][$fila][$columna]=1;
        }
        else{
           $_SESSION["butacas"][$fila][$columna]=0;
 
        }
        
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUTAQUICAS</title>
    <link rel="stylesheet" href="assets/css/estilos2.css">
</head>

<body>
    <h1>🎥 Vista de Butacas del Cine</h1>

    <div class="pantalla">PANTALLA</div>

    <!-- Formulario único -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="formButacas">
        <input type="hidden" name="fila_seleccionada" id="fila_seleccionada">
        <input type="hidden" name="columna_seleccionada" id="columna_seleccionada">
    </form>

    <div class="sala">
        <?php
            for ($f=1; $f <=$filas; $f++) { 
                for ($c=1; $c <=$columnas; $c++) { 
                    if ($_SESSION["butacas"][$f][$c]==0) {
                        echo "
                            <div>
                            <img src='assets/asiento-libre.png' class='butaca' data-fila='$f' data-columna='$c'>
                            </div>                        
                        ";
                    }
                    else{
                        echo "
                            <div>
                            <img src='assets/asiento-ocupado.png' class='butaca' data-fila='$f' data-columna='$c'>
                            </div>                        
                        ";                        
                    }
                }
            }
            
        ?>
        
    </div>
    <script>
        // Al hacer clic en una imagen, guarda el número y envía el formulario. 
        // Vamos a usar DATASET. Para ello, en las imagenes incluifremos el 
        // atributo 'data-fila' y 'data-columna'

        document.querySelectorAll('.butaca').forEach(butaca => {
            butaca.addEventListener('click', () => {
                const fila = butaca.dataset.fila;
                const columna = butaca.dataset.columna;

                console.log("fila:" + fila);
                console.log("columna:" + columna);

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

    <h2>PRECIO TOTAL:€</h2>
</body>

</html>