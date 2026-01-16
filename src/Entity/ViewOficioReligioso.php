<?php

namespace PHPMaker2024\hercules\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\hercules\AbstractEntity;
use PHPMaker2024\hercules\AdvancedSecurity;
use PHPMaker2024\hercules\UserProfile;
use function PHPMaker2024\hercules\Config;
use function PHPMaker2024\hercules\EntityManager;
use function PHPMaker2024\hercules\RemoveXss;
use function PHPMaker2024\hercules\HtmlDecode;
use function PHPMaker2024\hercules\EncryptPassword;

/**
 * Entity class for "view_oficio_religioso" table
 */
#[Entity]
#[Table(name: "view_oficio_religioso")]
class ViewOficioReligioso extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden", type: "bigint")]
    private string $norden;

    #[Id]
    #[Column(name: "Nexpediente", type: "bigint")]
    private string $nexpediente;

    #[Column(type: "string", nullable: true)]
    private ?string $cedula;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    #[Column(type: "string", nullable: true)]
    private ?string $apellido;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio2;

    #[Column(type: "string", nullable: true)]
    private ?string $ministro;

    #[Column(name: "servicio_atendido", type: "string", nullable: true)]
    private ?string $servicioAtendido;

    #[Column(name: "fecha_servicio", type: "datetime", nullable: true)]
    private ?DateTime $fechaServicio;

    public function __construct(string $norden, string $nexpediente)
    {
        $this->norden = $norden;
        $this->nexpediente = $nexpediente;
        $this->norden = "0";
        $this->servicioAtendido = "N";
    }

    public function getNorden(): string
    {
        return $this->norden;
    }

    public function setNorden(string $value): static
    {
        $this->norden = $value;
        return $this;
    }

    public function getNexpediente(): string
    {
        return $this->nexpediente;
    }

    public function setNexpediente(string $value): static
    {
        $this->nexpediente = $value;
        return $this;
    }

    public function getCedula(): ?string
    {
        return HtmlDecode($this->cedula);
    }

    public function setCedula(?string $value): static
    {
        $this->cedula = RemoveXss($value);
        return $this;
    }

    public function getNombre(): ?string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(?string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getApellido(): ?string
    {
        return HtmlDecode($this->apellido);
    }

    public function setApellido(?string $value): static
    {
        $this->apellido = RemoveXss($value);
        return $this;
    }

    public function getServicio(): ?string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(?string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }

    public function getServicio2(): ?string
    {
        return HtmlDecode($this->servicio2);
    }

    public function setServicio2(?string $value): static
    {
        $this->servicio2 = RemoveXss($value);
        return $this;
    }

    public function getMinistro(): ?string
    {
        return HtmlDecode($this->ministro);
    }

    public function setMinistro(?string $value): static
    {
        $this->ministro = RemoveXss($value);
        return $this;
    }

    public function getServicioAtendido(): ?string
    {
        return HtmlDecode($this->servicioAtendido);
    }

    public function setServicioAtendido(?string $value): static
    {
        $this->servicioAtendido = RemoveXss($value);
        return $this;
    }

    public function getFechaServicio(): ?DateTime
    {
        return $this->fechaServicio;
    }

    public function setFechaServicio(?DateTime $value): static
    {
        $this->fechaServicio = $value;
        return $this;
    }
}
