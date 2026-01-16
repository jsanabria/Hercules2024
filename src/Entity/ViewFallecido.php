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
 * Entity class for "view_fallecidos" table
 */
#[Entity]
#[Table(name: "view_fallecidos")]
class ViewFallecido extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nparcela", type: "bigint")]
    private string $nparcela;

    #[Column(type: "string", nullable: true)]
    private ?string $cedula;

    #[Column(type: "string", nullable: true)]
    private ?string $titular;

    #[Column(type: "string", nullable: true)]
    private ?string $contrato;

    #[Column(type: "string", nullable: true)]
    private ?string $seccion;

    #[Column(type: "string", nullable: true)]
    private ?string $modulo;

    #[Column(name: "sub_seccion", type: "string", nullable: true)]
    private ?string $subSeccion;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    #[Column(type: "string", nullable: true)]
    private ?string $boveda;

    #[Column(name: "ci_difunto", type: "string", nullable: true)]
    private ?string $ciDifunto;

    #[Column(type: "string", nullable: true)]
    private ?string $apellido1;

    #[Column(type: "string", nullable: true)]
    private ?string $apellido2;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre1;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre2;

    public function getNparcela(): string
    {
        return $this->nparcela;
    }

    public function setNparcela(string $value): static
    {
        $this->nparcela = $value;
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

    public function getTitular(): ?string
    {
        return HtmlDecode($this->titular);
    }

    public function setTitular(?string $value): static
    {
        $this->titular = RemoveXss($value);
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

    public function getSubSeccion(): ?string
    {
        return HtmlDecode($this->subSeccion);
    }

    public function setSubSeccion(?string $value): static
    {
        $this->subSeccion = RemoveXss($value);
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

    public function getBoveda(): ?string
    {
        return HtmlDecode($this->boveda);
    }

    public function setBoveda(?string $value): static
    {
        $this->boveda = RemoveXss($value);
        return $this;
    }

    public function getCiDifunto(): ?string
    {
        return HtmlDecode($this->ciDifunto);
    }

    public function setCiDifunto(?string $value): static
    {
        $this->ciDifunto = RemoveXss($value);
        return $this;
    }

    public function getApellido1(): ?string
    {
        return HtmlDecode($this->apellido1);
    }

    public function setApellido1(?string $value): static
    {
        $this->apellido1 = RemoveXss($value);
        return $this;
    }

    public function getApellido2(): ?string
    {
        return HtmlDecode($this->apellido2);
    }

    public function setApellido2(?string $value): static
    {
        $this->apellido2 = RemoveXss($value);
        return $this;
    }

    public function getNombre1(): ?string
    {
        return HtmlDecode($this->nombre1);
    }

    public function setNombre1(?string $value): static
    {
        $this->nombre1 = RemoveXss($value);
        return $this;
    }

    public function getNombre2(): ?string
    {
        return HtmlDecode($this->nombre2);
    }

    public function setNombre2(?string $value): static
    {
        $this->nombre2 = RemoveXss($value);
        return $this;
    }
}
