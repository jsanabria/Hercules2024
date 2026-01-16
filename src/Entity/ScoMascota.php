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
 * Entity class for "sco_mascota" table
 */
#[Entity]
#[Table(name: "sco_mascota")]
class ScoMascota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmascota", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nmascota;

    #[Column(name: "nombre_contratante", type: "string", nullable: true)]
    private ?string $nombreContratante;

    #[Column(name: "cedula_contratante", type: "string", nullable: true)]
    private ?string $cedulaContratante;

    #[Column(name: "direccion_contratante", type: "string", nullable: true)]
    private ?string $direccionContratante;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(name: "nombre_mascota", type: "string", nullable: true)]
    private ?string $nombreMascota;

    #[Column(type: "string", nullable: true)]
    private ?string $peso;

    #[Column(type: "string", nullable: true)]
    private ?string $raza;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(name: "tipo_otro", type: "string", nullable: true)]
    private ?string $tipoOtro;

    #[Column(type: "string", nullable: true)]
    private ?string $color;

    #[Column(type: "string", nullable: true)]
    private ?string $procedencia;

    #[Column(type: "string", nullable: true)]
    private ?string $tarifa;

    #[Column(type: "string", nullable: true)]
    private ?string $factura;

    #[Column(type: "float", nullable: true)]
    private ?float $costo;

    #[Column(type: "float", nullable: true)]
    private ?float $tasa;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(name: "fecha_cremacion", type: "date", nullable: true)]
    private ?DateTime $fechaCremacion;

    #[Column(name: "hora_cremacion", type: "time", nullable: true)]
    private ?DateTime $horaCremacion;

    #[Column(name: "username_registra", type: "string", nullable: true)]
    private ?string $usernameRegistra;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function getNmascota(): string
    {
        return $this->nmascota;
    }

    public function setNmascota(string $value): static
    {
        $this->nmascota = $value;
        return $this;
    }

    public function getNombreContratante(): ?string
    {
        return HtmlDecode($this->nombreContratante);
    }

    public function setNombreContratante(?string $value): static
    {
        $this->nombreContratante = RemoveXss($value);
        return $this;
    }

    public function getCedulaContratante(): ?string
    {
        return HtmlDecode($this->cedulaContratante);
    }

    public function setCedulaContratante(?string $value): static
    {
        $this->cedulaContratante = RemoveXss($value);
        return $this;
    }

    public function getDireccionContratante(): ?string
    {
        return HtmlDecode($this->direccionContratante);
    }

    public function setDireccionContratante(?string $value): static
    {
        $this->direccionContratante = RemoveXss($value);
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

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getNombreMascota(): ?string
    {
        return HtmlDecode($this->nombreMascota);
    }

    public function setNombreMascota(?string $value): static
    {
        $this->nombreMascota = RemoveXss($value);
        return $this;
    }

    public function getPeso(): ?string
    {
        return HtmlDecode($this->peso);
    }

    public function setPeso(?string $value): static
    {
        $this->peso = RemoveXss($value);
        return $this;
    }

    public function getRaza(): ?string
    {
        return HtmlDecode($this->raza);
    }

    public function setRaza(?string $value): static
    {
        $this->raza = RemoveXss($value);
        return $this;
    }

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }

    public function getTipoOtro(): ?string
    {
        return HtmlDecode($this->tipoOtro);
    }

    public function setTipoOtro(?string $value): static
    {
        $this->tipoOtro = RemoveXss($value);
        return $this;
    }

    public function getColor(): ?string
    {
        return HtmlDecode($this->color);
    }

    public function setColor(?string $value): static
    {
        $this->color = RemoveXss($value);
        return $this;
    }

    public function getProcedencia(): ?string
    {
        return HtmlDecode($this->procedencia);
    }

    public function setProcedencia(?string $value): static
    {
        $this->procedencia = RemoveXss($value);
        return $this;
    }

    public function getTarifa(): ?string
    {
        return HtmlDecode($this->tarifa);
    }

    public function setTarifa(?string $value): static
    {
        $this->tarifa = RemoveXss($value);
        return $this;
    }

    public function getFactura(): ?string
    {
        return HtmlDecode($this->factura);
    }

    public function setFactura(?string $value): static
    {
        $this->factura = RemoveXss($value);
        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(?float $value): static
    {
        $this->costo = $value;
        return $this;
    }

    public function getTasa(): ?float
    {
        return $this->tasa;
    }

    public function setTasa(?float $value): static
    {
        $this->tasa = $value;
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

    public function getFechaCremacion(): ?DateTime
    {
        return $this->fechaCremacion;
    }

    public function setFechaCremacion(?DateTime $value): static
    {
        $this->fechaCremacion = $value;
        return $this;
    }

    public function getHoraCremacion(): ?DateTime
    {
        return $this->horaCremacion;
    }

    public function setHoraCremacion(?DateTime $value): static
    {
        $this->horaCremacion = $value;
        return $this;
    }

    public function getUsernameRegistra(): ?string
    {
        return HtmlDecode($this->usernameRegistra);
    }

    public function setUsernameRegistra(?string $value): static
    {
        $this->usernameRegistra = RemoveXss($value);
        return $this;
    }

    public function getFechaRegistro(): ?DateTime
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?DateTime $value): static
    {
        $this->fechaRegistro = $value;
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
}
