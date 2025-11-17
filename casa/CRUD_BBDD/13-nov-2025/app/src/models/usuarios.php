<?php 
namespace App\models;
require __DIR__."/../../vendor/autoload.php";
use DateTime;

class Usuarios{
    private int|null $id;
    private string $nombre;
    private string $email;
    private string $password;
    private string $fecha_registro;

    public function __construct(int|null $id,string $nombre,string $email,string $password,string $fecha_registro)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->email=$email;
        $this->password=$password;
        $this->fecha_registro=$fecha_registro;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of fecha_registro
     */ 
    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }
}

?>