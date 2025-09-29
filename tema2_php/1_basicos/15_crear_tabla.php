<?php
$a = [
    [ //[0]
        'Nombre' => 'Mauro',//[0,0]
        'Apellido' => 'Chojrin',//[0,1]
        'Correo' => 'mauro.chojrin@leewayweb.com',//[0,2]
    ],
    [//[1]
        'Nombre' => 'Alberto',//[1,0]
        'Apellido' => 'Loffatti',//[1,1]
        'Correo' => 'aloffatti@hotmail.com',//[1,2]
    ],
    [//[2]
        'Nombre' => 'Foo',//[2,0]
        'Apellido' => 'Bar',//[2,1]
        'Correo' => 'foo_bar@example.com',//[2,2]
    ]
];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style=

>
    <table border="3">
        <thead>
            <tr>
                <!-- 
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                -->
                <?php
                    foreach ($a[0] as $campo => $value) {
                        echo "<th>$campo</th>";
                    }
                ?>
            </tr>

        </thead>
        <tbody>
                 <?php
                 foreach ($a as $fila) {//cojo de los datos la la key que serian las filas
                    echo "<tr>";
                        foreach ($fila as $valor) {//de las filas que serian las keys cojeria el valor
                            echo "<td>$valor</td>";
                        }
                    echo "</tr>";
                 }
                 
                 ?>
        </tbody>
        <tfoot>
  
        </tfoot>
    </table>
</body>
</html>