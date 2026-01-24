<?php
namespace App\Models;
require __DIR__ . "/../../vendor/autoload.php";

class Usuarios{
    private int|null $id;
    private string $nombre;
    private string $email;
    private string $password;
    private string $rol;
    private string $creado_en;

    public function __construct(int|null $id,string $nombre,string $email,string $password,string $rol,string $creado_en="")
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->email=$email;
        $this->password=$password;
        $this->rol=$rol;
        $this->creado_en=$creado_en;
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
     * Get the value of rol
     */ 
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Get the value of creado_en
     */ 
    public function getCreado_en()
    {
        return $this->creado_en;
    }
}

?>
