<?php
class Pelicula implements JsonSerializable{

    private $id;
    private $titulo;
    private $duracion;
    private $categoria;
    private $sinopsis;
    private $poster;

    public function __construct($titulo,$duracion,$categoria,$sinopsis,$poster)
    {
        $this->id=generarIdPersistente();//cada vez que llamo a la funcion suma 1;
        $this->titulo=$titulo;
        $this->duracion=$duracion;
        $this->categoria=$categoria;
        $this->sinopsis=$sinopsis;
        $this->poster=$poster;
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
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
     * Get the value of categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Get the value of sinopsis
     */ 
    public function getSinopsis()
    {
        return $this->sinopsis;
    }

    /**
     * Get the value of poster
     */ 
    public function getPoster()
    {
        return $this->poster;
    }
    public function jsonSerialize(): mixed
    {
        return[
            "id"=>$this->id,
            "titulo"=>$this->titulo,
            "duracion"=>$this->duracion,
            "categoria"=>$this->categoria,
            "sinopsis"=>$this->sinopsis,
            "poster"=>$this->poster
        ];
    }
}

?>