<?php
## Recogemos los datos con POST, y solo permitimos POST

if ($_SERVER["REQUEST_METHOD"] !="POST") {
    echo ("Petición no válida (Hay que pasar por el formulario)");
    //Volvemos al formulario
    print "<p> <a href='index.html'>Formulario </a> </p>";
}
?>