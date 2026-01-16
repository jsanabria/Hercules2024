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
 * Entity class for "sco_seguro" table
 */
#[Entity]
#[Table(name: "sco_seguro")]
class ScoSeguro extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nseguro", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nseguro;

    #[Column(name: "tipo_contratacion", type: "string")]
    private string $tipoContratacion;

    #[Column(name: "ci_rif", type: "string")]
    private string $ciRif;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    #[Column(type: "string", nullable: true)]
    private ?string $contacto;

    #[Column(type: "string", nullable: true)]
    private ?string $direccion;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono3;

    #[Column(type: "string", nullable: true)]
    private ?string $fax;

    #[Column(type: "string", nullable: true)]
    private ?string $email1;

    #[Column(type: "string", nullable: true)]
    private ?string $email2;

    #[Column(type: "string", nullable: true)]
    private ?string $email3;

    #[Column(type: "string", nullable: true)]
    private ?string $web;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    public function getNseguro(): int
    {
        return $this->nseguro;
    }

    public function setNseguro(int $value): static
    {
        $this->nseguro = $value;
        return $this;
    }

    public function getTipoContratacion(): string
    {
        return HtmlDecode($this->tipoContratacion);
    }

    public function setTipoContratacion(string $value): static
    {
        $this->tipoContratacion = RemoveXss($value);
        return $this;
    }

    public function getCiRif(): string
    {
        return HtmlDecode($this->ciRif);
    }

    public function setCiRif(string $value): static
    {
        $this->ciRif = RemoveXss($value);
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

    public function getContacto(): ?string
    {
        return HtmlDecode($this->contacto);
    }

    public function setContacto(?string $value): static
    {
        $this->contacto = RemoveXss($value);
        return $this;
    }

    public function getDireccion(): ?string
    {
        return HtmlDecode($this->direccion);
    }

    public function setDireccion(?string $value): static
    {
        $this->direccion = RemoveXss($value);
        return $this;
    }

    public function getTelefono1(): ?string
    {
        return HtmlDecode($this->telefono1);
    }

    public function setTelefono1(?string $value): static
    {
        $this->telefono1 = RemoveXss($value);
        return $this;
    }

    public function getTelefono2(): ?string
    {
        return HtmlDecode($this->telefono2);
    }

    public function setTelefono2(?string $value): static
    {
        $this->telefono2 = RemoveXss($value);
        return $this;
    }

    public function getTelefono3(): ?string
    {
        return HtmlDecode($this->telefono3);
    }

    public function setTelefono3(?string $value): static
    {
        $this->telefono3 = RemoveXss($value);
        return $this;
    }

    public function getFax(): ?string
    {
        return HtmlDecode($this->fax);
    }

    public function setFax(?string $value): static
    {
        $this->fax = RemoveXss($value);
        return $this;
    }

    public function getEmail1(): ?string
    {
        return HtmlDecode($this->email1);
    }

    public function setEmail1(?string $value): static
    {
        $this->email1 = RemoveXss($value);
        return $this;
    }

    public function getEmail2(): ?string
    {
        return HtmlDecode($this->email2);
    }

    public function setEmail2(?string $value): static
    {
        $this->email2 = RemoveXss($value);
        return $this;
    }

    public function getEmail3(): ?string
    {
        return HtmlDecode($this->email3);
    }

    public function setEmail3(?string $value): static
    {
        $this->email3 = RemoveXss($value);
        return $this;
    }

    public function getWeb(): ?string
    {
        return HtmlDecode($this->web);
    }

    public function setWeb(?string $value): static
    {
        $this->web = RemoveXss($value);
        return $this;
    }

    public function getActivo(): ?string
    {
        return $this->activo;
    }

    public function setActivo(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'activo' value");
        }
        $this->activo = $value;
        return $this;
    }
}
