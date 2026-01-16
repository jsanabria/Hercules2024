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
 * Entity class for "sco_mensaje_cliente" table
 */
#[Entity]
#[Table(name: "sco_mensaje_cliente")]
class ScoMensajeCliente extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmensaje_cliente", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nmensajeCliente;

    #[Column(type: "string", nullable: true)]
    private ?string $cedula;

    #[Column(type: "string", nullable: true)]
    private ?string $contrato;

    #[Column(type: "string", nullable: true)]
    private ?string $titular;

    #[Column(type: "string", nullable: true)]
    private ?string $difunto;

    #[Column(type: "string", nullable: true)]
    private ?string $contacto;

    #[Column(type: "string", nullable: true)]
    private ?string $celular;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $texto;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    public function getNmensajeCliente(): string
    {
        return $this->nmensajeCliente;
    }

    public function setNmensajeCliente(string $value): static
    {
        $this->nmensajeCliente = $value;
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

    public function getContrato(): ?string
    {
        return HtmlDecode($this->contrato);
    }

    public function setContrato(?string $value): static
    {
        $this->contrato = RemoveXss($value);
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

    public function getDifunto(): ?string
    {
        return HtmlDecode($this->difunto);
    }

    public function setDifunto(?string $value): static
    {
        $this->difunto = RemoveXss($value);
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

    public function getCelular(): ?string
    {
        return HtmlDecode($this->celular);
    }

    public function setCelular(?string $value): static
    {
        $this->celular = RemoveXss($value);
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

    public function getTexto(): ?string
    {
        return HtmlDecode($this->texto);
    }

    public function setTexto(?string $value): static
    {
        $this->texto = RemoveXss($value);
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
}
