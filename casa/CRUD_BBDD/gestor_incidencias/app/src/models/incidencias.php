<?php
namespace App\models;
require __DIR__. "/../../vendor/autoload.php";
class incidencias{
    private int |null $id;
    private string $titulo;
    private string $descripcion;
    private bool $resuelta;
    private int $id_usuario;

    public function __construct(int|null $id,string $titulo,string $descripcion,bool $resuelta,int $id_usuario)
    {
        $this->id=$id;
        $this->titulo=$titulo;
        $this->descripcion=$descripcion;
        $this->resuelta=$resuelta;
        $this->id_usuario=$id_usuario;
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
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get the value of resuelta
     */ 
    public function getResuelta()
    {
        return $this->resuelta;
    }

    /**
     * Get the value of id_usuario
     */ 
    public function getId_usuario()
    {
        return $this->id_usuario;
    }
}
?>