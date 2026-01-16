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
 * Entity class for "sco_cia" table
 */
#[Entity]
#[Table(name: "sco_cia")]
class ScoCia extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ncia", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ncia;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    #[Column(type: "string", nullable: true)]
    private ?string $rif;

    #[Column(type: "string", nullable: true)]
    private ?string $direccion;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono;

    #[Column(type: "string", nullable: true)]
    private ?string $contacto;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    public function getNcia(): int
    {
        return $this->ncia;
    }

    public function setNcia(int $value): static
    {
        $this->ncia = $value;
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

    public function getNombre(): ?string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(?string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getRif(): ?string
    {
        return HtmlDecode($this->rif);
    }

    public function setRif(?string $value): static
    {
        $this->rif = RemoveXss($value);
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

    public function getContacto(): ?string
    {
        return HtmlDecode($this->contacto);
    }

    public function setContacto(?string $value): static
    {
        $this->contacto = RemoveXss($value);
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
}
