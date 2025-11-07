<?php
class Usuario implements JsonSerializable {
    //Propiedades
    private int | null $id; //Puede ser int o null , en php7, ?int
    private string $nombre;
    private string $apellidos;
    private string $usuario;
    private string $password;//se guarda cifrado
    private DateTime $fecha_nac;

    //Constructor
    public function __construct(int |null $id,string $nombre, string $apellidos, string $usuario, string $passwordCifrada, DateTime $fecha_nac)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->usuario=$usuario;
        $this->password=$passwordCifrada;
        $this->fecha_nac=$fecha_nac;
    }

    //Magic method
    public function __get($property)
    {
        if (property_exists($this,$property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value)
    {
        if (property_exists($this,$property)) {
            $this->$property=$value;
        }
    }
    //Metodo para verificar una contraseña instroducida
    public function verificarPassword(string $passwrodPlano):bool{
        return password_verify($passwrodPlano,$this->password);
    }
    //Metodo adicional:calcular edad
    public function getEdad():int{
        $hoy=new DateTime();//si no le meto parametros guarda el dia de hoy
        return $hoy->diff($this->fecha_nac)->y;//la y sirve para el año.
    }
    public function jsonSerialize(): array
    {
        return [
            "id"=>$this->id,
            "nombre"=>$this->nombre,
            "apellidos"=>$this->apellidos,
            "usuario"=>$this->usuario,
            "fecha_nac"=>$this->fecha_nac->format('d/m/Y'),
        ];
    }
}

?>