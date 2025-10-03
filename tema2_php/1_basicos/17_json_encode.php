<?php
//CREAR JSON a partir de array asociativo unidimensional

$edades=array("Peter" =>35,
              "Zaida"=>38,
              "Joe"=>13);
$json=json_encode($edades);
echo $json;

echo "<hr>"; //==============================================

//Array de productos en PHP. Array Bidimensional.
$productos=[
    ["id"=> 1,"nombre" => "Laptop", "precio"=>1200],
    ["id"=> 2,"nombre" => "Mouse", "precio"=>20],
    ["id"=> 3,"nombre" => "Teclado", "precio"=>50]
];
$json=json_encode($productos,JSON_PRETTY_PRINT);
//header('Content-Type:application/json');
echo $json;
echo "<hr>";//=================================================

//Un objeto tambien lo podemos convertir en json
class Persona{
    public $nombre;
    public $apellidos;

    //constructor
    public function __construct($nombre,$apellidos){
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
    }
}
//Crear un objeto de tipo Persona
$persona1=new Persona("Juan","Marcos Rubio");

//COnvertir el objeto a JSON
$json=json_encode($persona1);
echo $json;
?>