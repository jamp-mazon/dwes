<?php
class Pelicula implements JsonSerializable{
    private $titulo;
    private $duracion;
    private $genero;
    private $poster;

    function __construct($titulo,$duracion,$genero,$poster){
        $this->titulo=$titulo;
        $this->duracion =$duracion;
        $this->genero =$genero ;
        $this->poster =$poster ;
    }
    

    /**
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get the value of duracion
     */ 
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Get the value of genero
     */ 
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Get the value of poster
     */ 
    public function getPoster()
    {
        return $this->poster;
    }
    function jsonSerialize(): mixed
    {
        return[
            "titulo"=>$this->titulo,
            "duracion"=>$this->duracion,
            "genero"=>$this->genero,
            "poster"=>$this->poster,

        ];
    }
}

?>