<?php
class Usuario implements JsonSerializable{

    private $nick;
    private $email;
    private $password;
    private $sexo;
    private $categorias;
    private $imagen_perfil;
    private $rol;

    function __construct($nick,$email,$password,$sexo,$categorias,$imagen_perfil,$rol)
    {
        $this->nick=$nick;
        $this->email=$email;
        $this->password=password_hash($password,PASSWORD_DEFAULT);
        $this->sexo=$sexo;
        $this->categorias=$categorias;
        $this->imagen_perfil=$imagen_perfil;
        $this->rol=$rol;

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
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of sexo
     */ 
    public function getSexo()
    {
        return $this->sexo;
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
     * Get the value of rol
     */ 
    public function getRol()
    {
        return $this->rol;
    }
    function jsonSerialize(): mixed
    {
        return[
            "nick"=>$this->nick,
            "email"=>$this->email,
            "password"=>$this->password,
            "sexo"=>$this->sexo,
            "categorias"=>$this->categorias,
            "imagen_perfil"=>$this->imagen_perfil,
            "rol"=>$this->rol 
        ];
    }
}

?>