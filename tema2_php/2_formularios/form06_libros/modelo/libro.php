<?php

class Libro implements JsonSerializable{
    
    private $titulo;
    private $autor;
    private $anio;
    private $generos;
    private $caratula;


    public function __construct(string $titulo,string $autor,int $anio,string $generos,string $caratula){
        $this->titulo=$titulo;
        $this->autor=$autor;
        $this->anio=$anio;
        $this->generos=$generos;
        $this->caratula=$caratula;
    }
    public function getTitulo(){
        return $this->titulo;

    }
    public function getAutor(){
        return $this->autor;
    }
    public function getAnio(){
        return $this->anio;
    }
    public function getGeneros(){
        return $this->generos;
    }
    public function getCaratula(){
        return $this->caratula;
    }
    // Implementación requerida por JsonSerializable
    public function jsonSerialize(): mixed {
        return [
            'titulo'   => $this->titulo,
            'autor'    => $this->autor,
            'anio'     => $this->anio,
            'generos'  => $this->generos,
            'caratula' => $this->caratula
        ];
    }
}



?>