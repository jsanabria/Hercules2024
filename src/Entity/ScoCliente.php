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
 * Entity class for "sco_cliente" table
 */
#[Entity]
#[Table(name: "sco_cliente")]
class ScoCliente extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ncliente", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ncliente;

    #[Column(name: "rif_ci", type: "string", nullable: true)]
    private ?string $rifCi;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    #[Column(type: "string", nullable: true)]
    private ?string $direccion;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(type: "string", nullable: true)]
    private ?string $fax;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $web;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    public function __construct()
    {
        $this->activo = "S";
    }

    public function getNcliente(): int
    {
        return $this->ncliente;
    }

    public function setNcliente(int $value): static
    {
        $this->ncliente = $value;
        return $this;
    }

    public function getRifCi(): ?string
    {
        return HtmlDecode($this->rifCi);
    }

    public function setRifCi(?string $value): static
    {
        $this->rifCi = RemoveXss($value);
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

    public function getDireccion(): ?string
    {
        return HtmlDecode($this->direccion);
    }

    public function setDireccion(?string $value): static
    {
        $this->direccion = RemoveXss($value);
        return $this;
    }

    public function getTelefono(): ?string
    {
        return HtmlDecode($this->telefono);
    }

    public function setTelefono(?string $value): static
    {
        $this->telefono = RemoveXss($value);
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

    public function getFax(): ?string
    {
        return HtmlDecode($this->fax);
    }

    public function setFax(?string $value): static
    {
        $this->fax = RemoveXss($value);
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
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
