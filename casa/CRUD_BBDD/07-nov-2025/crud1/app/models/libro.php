<?php 
class Libro {
    private $codigo;
    private $titulo;
    private $autor;
    private $disponible;

    public function __construct(int|null $codigo,string $titulo,string $autor,bool $disponible)
    {
        $this->codigo=$codigo;
        $this->titulo=$titulo;
        $this->autor=$autor;
        $this->disponible=$disponible;
    }
    //Metodo magico para coger los get y los setters;
    public function __get($name)
    {
        if (property_exists($this,$name)) {
            return $this->$name;
        }
    }
    public function __set($name, $value)
    {
        if (property_exists($this,$name)) {
            $this->$name=$value;
        }
    }
}

?>