<?php
namespace Api\models;

use DateInterval;
use Monolog\DateTimeImmutable;

class api_key{
    private $key_hash;
    private $rol;
    private $activa;
    private $creada_en;

    public function __construct($key_hash,$rol,$activa,$creada_en)
    {
        $this->key_hash=$key_hash;
        $this->rol=$rol;
        $this->activa=$activa;
        $this->creada_en=$creada_en;
    }

    public function estaCaducada(DateTimeImmutable $ahora):bool {
        $fechaCaducidad=$this->creada_en->add(new DateInterval("P1M"));//compara el momento del creado con el ahora
        return $ahora>=$fechaCaducidad;
    }
    
    /**
     * Get the value of key_hash
     */ 
    public function getKey_hash()
    {
        return $this->key_hash;
    }

    /**
     * Get the value of rol
     */ 
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Get the value of activa
     */ 
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Get the value of creada_en
     */ 
    public function getCreada_en()
    {
        return $this->creada_en;
    }
}

?>