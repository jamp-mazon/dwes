<?php
class Libro implements JsonSerializable{

    private $titulo;
    private $autor;
    private $anio;
    private $generos;
    private $caratula;

    public function __construct($titulo,$autor,$anio,$generos,$caratula)
    {
        $this->titulo=$titulo;
        $this->autor=$autor;
        $this->$anio=$anio;
        $this->$generos=$generos;
        $this->caratula=$caratula;
    }
    

    /**
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get the value of autor
     */ 
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Get the value of anio
     */ 
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Get the value of generos
     */ 
    public function getGeneros()
    {
        return $this->generos;
    }

    /**
     * Get the value of caratula
     */ 
    public function getCaratula()
    {
        return $this->caratula;
    }
    public function jsonSerialize(): mixed
    {
        return [
            "titulo"=>$this->titulo,
            "autor"=>$this->autor,
            "anio"=>$this->anio,
            "generos"=>$this->generos,
            "caratula"=>$this->caratula
        ];
    }
}

?>