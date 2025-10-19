<?php

    class Usuario implements JsonSerializable{

        private $nombre;
        private $email;
        private $edad;
        private $password;
        private $generos;
        private $sexo;

        public function __construct($nombre,$edad,$email,$password,$generos,$sexo)
        {
            $this->nombre=$nombre;
            $this->email=$email;
            $this->edad=$edad;
            $this->password=password_hash($password,PASSWORD_DEFAULT);
            $this->generos=$generos;
            $this->sexo=$sexo;
        }
        
        function jsonSerialize(): mixed{
        return[
            'nombre' => $this->nombre,
            'email' => $this->email,
            'edad' => $this->edad,
            'password' => $this->password,
            'generos' => $this->generos,
            'sexo' => $this->sexo
        ];
    }

    }
    

?>