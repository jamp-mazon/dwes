<?php
class Usuario implements JsonSerializable{

    private $nick;//debe ser unico
    private $email;
    private $password;//contraseña hashseada
    private $genero;
    private $aficiones;

    public function __construct($nick,$email,$password,$genero,$aficiones)
    {
        $this->nick=$nick;
        $this->email=$email;
        $this->password=password_hash($password,PASSWORD_DEFAULT);//hasheo la pass
        $this->genero=$genero;
        $this->aficiones=$aficiones;//esto sera un array.

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
     * Get the value of genero
     */ 
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Get the value of aficiones
     */ 
    public function getAficiones()
    {
        return $this->aficiones;
    }
    public function jsonSerialize(): mixed
    {
        return[
            "nick"=>$this->nick,
            "email"=>$this->email,
            "password"=>$this->password,
            "genero"=>$this->genero,
            "aficiones"=>$this->aficiones
        ];
    }
}

?>