<?php
class Usuario implements JsonSerializable{

    private $nick;
    private $email;
    private $generos;
    private $password;

    function __construct($nick,$email,$generos,$password)
    {
        $this->nick=$nick;
        $this->email=$email;
        $this->generos=$generos;
        $this->password=password_hash($password,PASSWORD_DEFAULT);
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
     * Get the value of generos
     */ 
    public function getGeneros()
    {
        return $this->generos;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }
    function jsonSerialize(): mixed
    {
        return[
            "nick"=>$this->nick,
            "email"=>$this->email,
            "generos"=>$this->generos,
            "password"=>$this->password
        ];
    }
}

?>