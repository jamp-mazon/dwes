<?php

class Persona{
    private $DNI;
    private $nombre;
    private $apellidos;

    function __construct($DNI,$nombre,$apellidos){
        $this->DNI=$DNI;
        $this ->nombre=$nombre;
        $this->apellidos=$apellidos;
    }
    public function __toString()
    {
        return "Persona: $this->nombre $this->apellidos &nbsp&nbsp[DNI:$this->DNI]";
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function getDNI(){
        return $this->DNI;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }    
    
}
$pers=new Persona ("1111111111A","Jose","Mazon");
echo ($pers)."<br>";
print("<pre>");
$pers->setNombre("Paco");
print_r($pers);
print("</pre>");

?>