<?php 
namespace App\models;

use DateTime;

require __DIR__ . "/../../vendor/autoload.php";

class Tarea{
    private int|null $id;
    private string $descripcion;
    private bool $completada;
    private DateTime $fecha_creacion;

    public function __construct(int|null $id,string $descripcion,bool $completada)
    {
        $this->id=$id;
        $this->descripcion=$descripcion;
        $this->completada=$completada;
    }
    public function completarTarea(){
        return $this->completada=true;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get the value of completada
     */ 
    public function getCompletada()
    {
        return $this->completada;
    }

    /**
     * Set the value of completada
     *
     * @return  self
     */ 
    public function setCompletada($completada)
    {
        $this->completada = $completada;

        return $this->completada;
    }
 }
?>