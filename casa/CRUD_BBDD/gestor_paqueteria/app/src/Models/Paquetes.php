<?php
namespace App\Models;

require __DIR__ . "/../../vendor/autoload.php";

class Paquetes
{
    private int|null $id;
    private int $id_cliente;
    private string $descripcion;
    private string $fecha_creacion;
    private string $estado; // pendiente | en_reparto | entregado | incidencia
    private ?string $notas;
    private string $creado_en;

    public function __construct(
        int|null $id,
        int $id_cliente,
        string $descripcion,
        string $fecha_creacion,
        string $estado = "pendiente",
        ?string $notas = null,
        string $creado_en = ""
    ) {
        $this->id = $id;
        $this->id_cliente = $id_cliente;
        $this->descripcion = $descripcion;
        $this->fecha_creacion = $fecha_creacion;
        $this->estado = $estado;
        $this->notas = $notas;
        $this->creado_en = $creado_en;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): int
    {
        return $this->id_cliente;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getFechaCreacion(): string
    {
        return $this->fecha_creacion;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function setNotas(?string $notas): void
    {
        $this->notas = $notas;
    }

    public function getCreadoEn(): string
    {
        return $this->creado_en;
    }
}

?>
