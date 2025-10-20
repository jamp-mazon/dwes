<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>FABULARIA</title>
</head>
<body>
    <header>
        <?php
            include("header.php");
        ?>
    </header>
    <main>
    <?php
        $bbdd_libros=[];//me creo un array vacio
        $bbdd_json=file_get_contents("bbdd/data.json",FILE_USE_INCLUDE_PATH);//meto en una variable los datos del json
        $bbdd_libros=json_decode($bbdd_json);//meto los datos del json dentro del array vacio
        ?>
        <table border="3">
            <caption>Libros Subidos</caption>
            <thead>
                
                <?php
                echo "<tr>";
                    foreach ($bbdd_libros[0] as $key => $value) {
                        echo "<th>$key</th>";
                    }
                echo "</tr>";    
                ?>
            </thead>
            <tbody>
                <?php foreach ($bbdd_libros as $libro) {
                        echo "<tr>";
                        foreach ($libro  as $llave => $valor) {

                            if ($llave=="caratula") {
                                echo "<td>";
                                    echo "<img width='50px' src='bbdd/$valor'";
                                echo "<td>";                                
                            }
                            else if(is_array($valor)){
                                echo "<td>";
                                    echo "<select> ";
                                        foreach ($valor as $genero) {
                                            echo "<option>$genero</option>";
                                        }                                   
                            }
                            else{
                                echo "<td>$valor</td>";
                            }
                        }    
                        echo "</tr>";
                }








                        // foreach ($key as $value) {
                        //     if (is_array($value)) {
                        //         echo "<td>";
                        //             echo "<select>";
                        //                 foreach ($value as $genero) {
                        //                     echo "<option>$genero</option>";
                        //                 }
                        //         echo "</td>";

                        //     }
                        // }    
                        // if ($value=="caratula") {
                        //         echo "<td>";

                        //             echo "<img width='50px' src='bbdd/$value'";
                        //         echo "<td>";
                        // }
                        // else{
                        //     echo "<td>$value</td>";
                        //     }    
                            
                        // }
                        // echo "</tr>"; 
                ?>
            </tbody>
        </table>        
    </main>
    <footer>
        <?php
            include("footer.php");
        ?>
    </footer>
</body>
</html>