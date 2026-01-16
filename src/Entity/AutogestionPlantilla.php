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
 * Entity class for "autogestion_plantillas" table
 */
#[Entity]
#[Table(name: "autogestion_plantillas")]
class AutogestionPlantilla extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nplantilla", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nplantilla;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Column(type: "string", nullable: true)]
    private ?string $script;

    #[Column(type: "integer", nullable: true)]
    private ?int $nivel;

    #[Column(type: "integer", nullable: true)]
    private ?int $orden;

    #[Column(type: "string", nullable: true)]
    private ?string $codigo;

    #[Column(type: "text", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "string", nullable: true)]
    private ?string $imagen;

    #[Column(type: "string", nullable: true)]
    private ?string $mostrar;

    public function getNplantilla(): int
    {
        return $this->nplantilla;
    }

    public function setNplantilla(int $value): static
    {
        $this->nplantilla = $value;
        return $this;
    }

    public function getServicioTipo(): ?string
    {
        return HtmlDecode($this->servicioTipo);
    }

    public function setServicioTipo(?string $value): static
    {
        $this->servicioTipo = RemoveXss($value);
        return $this;
    }

    public function getScript(): ?string
    {
        return HtmlDecode($this->script);
    }

    public function setScript(?string $value): static
    {
        $this->script = RemoveXss($value);
        return $this;
    }

    public function getNivel(): ?int
    {
        return $this->nivel;
    }

    public function setNivel(?int $value): static
    {
        $this->nivel = $value;
        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(?int $value): static
    {
        $this->orden = $value;
        return $this;
    }

    public function getCodigo(): ?string
    {
        return HtmlDecode($this->codigo);
    }

    public function setCodigo(?string $value): static
    {
        $this->codigo = RemoveXss($value);
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(?string $value): static
    {
        $this->descripcion = RemoveXss($value);
        return $this;
    }

    public function getImagen(): ?string
    {
        return HtmlDecode($this->imagen);
    }

    public function setImagen(?string $value): static
    {
        $this->imagen = RemoveXss($value);
        return $this;
    }

    public function getMostrar(): ?string
    {
        return $this->mostrar;
    }

    public function setMostrar(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'mostrar' value");
        }
        $this->mostrar = $value;
        return $this;
    }
}
