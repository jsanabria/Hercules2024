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
 * Entity class for "sco_entrada_salida" table
 */
#[Entity]
#[Table(name: "sco_entrada_salida")]
class ScoEntradaSalida extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nentrada_salida", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nentradaSalida;

    #[Column(name: "tipo_doc", type: "string", nullable: true)]
    private ?string $tipoDoc;

    #[Column(type: "integer", nullable: true)]
    private ?int $proveedor;

    #[Column(type: "string", nullable: true)]
    private ?string $clasificacion;

    #[Column(type: "string", nullable: true)]
    private ?string $documento;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "float", nullable: true)]
    private ?float $monto;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $registro;

    public function getNentradaSalida(): string
    {
        return $this->nentradaSalida;
    }

    public function setNentradaSalida(string $value): static
    {
        $this->nentradaSalida = $value;
        return $this;
    }

    public function getTipoDoc(): ?string
    {
        return HtmlDecode($this->tipoDoc);
    }

    public function setTipoDoc(?string $value): static
    {
        $this->tipoDoc = RemoveXss($value);
        return $this;
    }

    public function getProveedor(): ?int
    {
        return $this->proveedor;
    }

    public function setProveedor(?int $value): static
    {
        $this->proveedor = $value;
        return $this;
    }

    public function getClasificacion(): ?string
    {
        return HtmlDecode($this->clasificacion);
    }

    public function setClasificacion(?string $value): static
    {
        $this->clasificacion = RemoveXss($value);
        return $this;
    }

    public function getDocumento(): ?string
    {
        return HtmlDecode($this->documento);
    }

    public function setDocumento(?string $value): static
    {
        $this->documento = RemoveXss($value);
        return $this;
    }

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }

    public function getNota(): ?string
    {
        return HtmlDecode($this->nota);
    }

    public function setNota(?string $value): static
    {
        $this->nota = RemoveXss($value);
        return $this;
    }

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(?float $value): static
    {
        $this->monto = $value;
        return $this;
    }

    public function getRegistro(): ?DateTime
    {
        return $this->registro;
    }

    public function setRegistro(?DateTime $value): static
    {
        $this->registro = $value;
        return $this;
    }
}
