<?php 
namespace App\models;

use DateTime;

//require __DIR__."/../../vendor/autoload.php";

class Tarea{
    // id INT AUTO_INCREMENT PRIMARY KEY,
    // descripcion VARCHAR(255) NOT NULL,
    // completada BOOLEAN DEFAULT FALSE,
    // fecha_creacion DATETIME DEFAULT CURRENT_DATE

    public int|null $id;
    public string $descripcion;
    public bool $completada;
    public DateTime $fecha_creacion;

    public function __construct(int|null $id,string $descripcion,bool $completada=false){
        $this->id=$id;
        $this->descripcion=$descripcion;
        $this->completada=$completada;
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

        return $this;
    }
}
?>