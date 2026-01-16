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
 * Entity class for "sco_lapidas" table
 */
#[Entity]
#[Table(name: "sco_lapidas")]
class ScoLapida extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nlapidas", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nlapidas;

    #[Column(type: "string", nullable: true)]
    private ?string $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $seccion;

    #[Column(type: "string", nullable: true)]
    private ?string $modulo;

    #[Column(type: "string", nullable: true)]
    private ?string $subseccion;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    #[Column(type: "string", nullable: true)]
    private ?string $contrato;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "string", nullable: true)]
    private ?string $asesor;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(type: "string", nullable: true)]
    private ?string $instalacion;

    #[Column(type: "string", nullable: true)]
    private ?string $nota1;

    #[Column(type: "string", nullable: true)]
    private ?string $cliente;

    #[Column(type: "string", nullable: true)]
    private ?string $nota2;

    #[Column(type: "string", nullable: true)]
    private ?string $difunto;

    public function getNlapidas(): int
    {
        return $this->nlapidas;
    }

    public function setNlapidas(int $value): static
    {
        $this->nlapidas = $value;
        return $this;
    }

    public function getFecha(): ?string
    {
        return HtmlDecode($this->fecha);
    }

    public function setFecha(?string $value): static
    {
        $this->fecha = RemoveXss($value);
        return $this;
    }

    public function getSeccion(): ?string
    {
        return HtmlDecode($this->seccion);
    }

    public function setSeccion(?string $value): static
    {
        $this->seccion = RemoveXss($value);
        return $this;
    }

    public function getModulo(): ?string
    {
        return HtmlDecode($this->modulo);
    }

    public function setModulo(?string $value): static
    {
        $this->modulo = RemoveXss($value);
        return $this;
    }

    public function getSubseccion(): ?string
    {
        return HtmlDecode($this->subseccion);
    }

    public function setSubseccion(?string $value): static
    {
        $this->subseccion = RemoveXss($value);
        return $this;
    }

    public function getParcela(): ?string
    {
        return HtmlDecode($this->parcela);
    }

    public function setParcela(?string $value): static
    {
        $this->parcela = RemoveXss($value);
        return $this;
    }

    public function getContrato(): ?string
    {
        return HtmlDecode($this->contrato);
    }

    public function setContrato(?string $value): static
    {
        $this->contrato = RemoveXss($value);
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

    public function getAsesor(): ?string
    {
        return HtmlDecode($this->asesor);
    }

    public function setAsesor(?string $value): static
    {
        $this->asesor = RemoveXss($value);
        return $this;
    }

    public function getEstatus(): ?string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(?string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }

    public function getInstalacion(): ?string
    {
        return HtmlDecode($this->instalacion);
    }

    public function setInstalacion(?string $value): static
    {
        $this->instalacion = RemoveXss($value);
        return $this;
    }

    public function getNota1(): ?string
    {
        return HtmlDecode($this->nota1);
    }

    public function setNota1(?string $value): static
    {
        $this->nota1 = RemoveXss($value);
        return $this;
    }

    public function getCliente(): ?string
    {
        return HtmlDecode($this->cliente);
    }

    public function setCliente(?string $value): static
    {
        $this->cliente = RemoveXss($value);
        return $this;
    }

    public function getNota2(): ?string
    {
        return HtmlDecode($this->nota2);
    }

    public function setNota2(?string $value): static
    {
        $this->nota2 = RemoveXss($value);
        return $this;
    }

    public function getDifunto(): ?string
    {
        return HtmlDecode($this->difunto);
    }

    public function setDifunto(?string $value): static
    {
        $this->difunto = RemoveXss($value);
        return $this;
    }
}
