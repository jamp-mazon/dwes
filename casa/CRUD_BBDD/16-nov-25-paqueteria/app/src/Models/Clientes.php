<?php
namespace App\Models;

require __DIR__ . "/../../vendor/autoload.php";
use PDO;
use App\Models\Basedatos;

class Clientes{
    private $id;
    private $nombre;
    private $telefono;
    private $direccion;
    private $ciudad;
    private $cp;
    private $cliente_desde;

    public function __construct($nombre,$telefono,$direccion,$ciudad,$cp)
    {
        $this->id=null;
        $this->nombre=$nombre;
        $this->telefono=$telefono;
        $this->direccion=$direccion;
        $this->ciudad=$ciudad;
        $this->cp=$cp;
    }
    public function obtenerClientes(): array
    {
        $mibd = new Basedatos();
        return $mibd->obtener_clientes();
    }
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of telefono
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Get the value of direccion
     */ 
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Get the value of ciudad
     */ 
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Get the value of cp
     */ 
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Get the value of cliente_desde
     */ 
    public function getCliente_desde()
    {
        return $this->cliente_desde;
    }

    /**
     * Set the value of cliente_desde
     *
     * @return  self
     */ 
    public function setCliente_desde($cliente_desde)
    {
        $this->cliente_desde = $cliente_desde;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */ 
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }
}

?>
