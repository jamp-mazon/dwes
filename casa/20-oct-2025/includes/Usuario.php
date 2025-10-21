<?php
 class Usuario implements JsonSerializable{

    private $nick;
    private $email;
    private $password;
    private $genero;
    private $categorias;
    private $imagen_perfil;
    private $esAdmin;

    public function __construct($nick,$email,$password,$genero,$categorias,$imagen_perfil,$esAdmin)
    {
        $this->nick=$nick;
        $this->$email=$email;
        $this->password=password_hash($password,PASSWORD_DEFAULT);
        $this->genero=$genero;
        $this->categorias=$categorias;
        $this->imagen_perfil=$imagen_perfil;
        $this->esAdmin=$esAdmin;
    }

    /**
     * Get the value of nick
     */ 
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of genero
     */ 
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Get the value of categorias
     */ 
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Get the value of imagen_perfil
     */ 
    public function getImagen_perfil()
    {
        return $this->imagen_perfil;
    }

    /**
     * Set the value of imagen_perfil
     *
     * @return  self
     */ 
    public function setImagen_perfil($imagen_perfil)
    {
        $this->imagen_perfil = $imagen_perfil;

        return $this;
    }
    public function jsonSerialize(): mixed
    {
        return[
            "nick"=>$this->nick,
            "email"=>$this->email,
            "genero"=>$this->genero,
            "categorias"=>$this->categorias,
            "imagen_perfil"=>$this->imagen_perfil,
            "esAdmin"=>$this->esAdmin
        ];
    }

    /**
     * Get the value of esAdmin
     */ 
    public function getEsAdmin()
    {
        return $this->esAdmin;
    }
 }

?>