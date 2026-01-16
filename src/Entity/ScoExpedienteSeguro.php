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
 * Entity class for "sco_expediente_seguros" table
 */
#[Entity]
#[Table(name: "sco_expediente_seguros")]
class ScoExpedienteSeguro extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente_seguros", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nexpedienteSeguros;

    #[Column(type: "integer")]
    private int $seguro;

    #[Column(name: "nombre_contacto", type: "string")]
    private string $nombreContacto;

    #[Column(name: "parentesco_contacto", type: "string")]
    private string $parentescoContacto;

    #[Column(name: "telefono_contacto1", type: "string")]
    private string $telefonoContacto1;

    #[Column(name: "telefono_contacto2", type: "string", nullable: true)]
    private ?string $telefonoContacto2;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(name: "cedula_fallecido", type: "string", unique: true, nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellidos_fallecido", type: "string", nullable: true)]
    private ?string $apellidosFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $sexo;

    #[Column(name: "fecha_nacimiento", type: "date", nullable: true)]
    private ?DateTime $fechaNacimiento;

    #[Column(name: "edad_fallecido", type: "smallint", nullable: true)]
    private ?int $edadFallecido;

    #[Column(name: "estado_civil", type: "string", nullable: true)]
    private ?string $estadoCivil;

    #[Column(name: "lugar_nacimiento_fallecido", type: "string", nullable: true)]
    private ?string $lugarNacimientoFallecido;

    #[Column(name: "lugar_ocurrencia", type: "string", nullable: true)]
    private ?string $lugarOcurrencia;

    #[Column(name: "direccion_ocurrencia", type: "string", nullable: true)]
    private ?string $direccionOcurrencia;

    #[Column(name: "fecha_ocurrencia", type: "date", nullable: true)]
    private ?DateTime $fechaOcurrencia;

    #[Column(name: "hora_ocurrencia", type: "time", nullable: true)]
    private ?DateTime $horaOcurrencia;

    #[Column(name: "causa_ocurrencia", type: "string", nullable: true)]
    private ?string $causaOcurrencia;

    #[Column(name: "causa_otro", type: "string", nullable: true)]
    private ?string $causaOtro;

    #[Column(name: "descripcion_ocurrencia", type: "text", nullable: true)]
    private ?string $descripcionOcurrencia;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(name: "user_registra", type: "string", nullable: true)]
    private ?string $userRegistra;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(type: "bigint", nullable: true)]
    private ?string $expediente;

    #[Column(type: "string", nullable: true)]
    private ?string $religion;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(type: "integer", nullable: true)]
    private ?int $estatus;

    #[Column(type: "integer", nullable: true)]
    private ?int $funeraria;

    public function __construct()
    {
        $this->expediente = "0";
        $this->religion = "0";
    }

    public function getNexpedienteSeguros(): string
    {
        return $this->nexpedienteSeguros;
    }

    public function setNexpedienteSeguros(string $value): static
    {
        $this->nexpedienteSeguros = $value;
        return $this;
    }

    public function getSeguro(): int
    {
        return $this->seguro;
    }

    public function setSeguro(int $value): static
    {
        $this->seguro = $value;
        return $this;
    }

    public function getNombreContacto(): string
    {
        return HtmlDecode($this->nombreContacto);
    }

    public function setNombreContacto(string $value): static
    {
        $this->nombreContacto = RemoveXss($value);
        return $this;
    }

    public function getParentescoContacto(): string
    {
        return HtmlDecode($this->parentescoContacto);
    }

    public function setParentescoContacto(string $value): static
    {
        $this->parentescoContacto = RemoveXss($value);
        return $this;
    }

    public function getTelefonoContacto1(): string
    {
        return HtmlDecode($this->telefonoContacto1);
    }

    public function setTelefonoContacto1(string $value): static
    {
        $this->telefonoContacto1 = RemoveXss($value);
        return $this;
    }

    public function getTelefonoContacto2(): ?string
    {
        return HtmlDecode($this->telefonoContacto2);
    }

    public function setTelefonoContacto2(?string $value): static
    {
        $this->telefonoContacto2 = RemoveXss($value);
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

    public function getCedulaFallecido(): ?string
    {
        return HtmlDecode($this->cedulaFallecido);
    }

    public function setCedulaFallecido(?string $value): static
    {
        $this->cedulaFallecido = RemoveXss($value);
        return $this;
    }

    public function getNombreFallecido(): ?string
    {
        return HtmlDecode($this->nombreFallecido);
    }

    public function setNombreFallecido(?string $value): static
    {
        $this->nombreFallecido = RemoveXss($value);
        return $this;
    }

    public function getApellidosFallecido(): ?string
    {
        return HtmlDecode($this->apellidosFallecido);
    }

    public function setApellidosFallecido(?string $value): static
    {
        $this->apellidosFallecido = RemoveXss($value);
        return $this;
    }

    public function getSexo(): ?string
    {
        return HtmlDecode($this->sexo);
    }

    public function setSexo(?string $value): static
    {
        $this->sexo = RemoveXss($value);
        return $this;
    }

    public function getFechaNacimiento(): ?DateTime
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?DateTime $value): static
    {
        $this->fechaNacimiento = $value;
        return $this;
    }

    public function getEdadFallecido(): ?int
    {
        return $this->edadFallecido;
    }

    public function setEdadFallecido(?int $value): static
    {
        $this->edadFallecido = $value;
        return $this;
    }

    public function getEstadoCivil(): ?string
    {
        return HtmlDecode($this->estadoCivil);
    }

    public function setEstadoCivil(?string $value): static
    {
        $this->estadoCivil = RemoveXss($value);
        return $this;
    }

    public function getLugarNacimientoFallecido(): ?string
    {
        return HtmlDecode($this->lugarNacimientoFallecido);
    }

    public function setLugarNacimientoFallecido(?string $value): static
    {
        $this->lugarNacimientoFallecido = RemoveXss($value);
        return $this;
    }

    public function getLugarOcurrencia(): ?string
    {
        return HtmlDecode($this->lugarOcurrencia);
    }

    public function setLugarOcurrencia(?string $value): static
    {
        $this->lugarOcurrencia = RemoveXss($value);
        return $this;
    }

    public function getDireccionOcurrencia(): ?string
    {
        return HtmlDecode($this->direccionOcurrencia);
    }

    public function setDireccionOcurrencia(?string $value): static
    {
        $this->direccionOcurrencia = RemoveXss($value);
        return $this;
    }

    public function getFechaOcurrencia(): ?DateTime
    {
        return $this->fechaOcurrencia;
    }

    public function setFechaOcurrencia(?DateTime $value): static
    {
        $this->fechaOcurrencia = $value;
        return $this;
    }

    public function getHoraOcurrencia(): ?DateTime
    {
        return $this->horaOcurrencia;
    }

    public function setHoraOcurrencia(?DateTime $value): static
    {
        $this->horaOcurrencia = $value;
        return $this;
    }

    public function getCausaOcurrencia(): ?string
    {
        return HtmlDecode($this->causaOcurrencia);
    }

    public function setCausaOcurrencia(?string $value): static
    {
        $this->causaOcurrencia = RemoveXss($value);
        return $this;
    }

    public function getCausaOtro(): ?string
    {
        return HtmlDecode($this->causaOtro);
    }

    public function setCausaOtro(?string $value): static
    {
        $this->causaOtro = RemoveXss($value);
        return $this;
    }

    public function getDescripcionOcurrencia(): ?string
    {
        return HtmlDecode($this->descripcionOcurrencia);
    }

    public function setDescripcionOcurrencia(?string $value): static
    {
        $this->descripcionOcurrencia = RemoveXss($value);
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

    public function getUserRegistra(): ?string
    {
        return HtmlDecode($this->userRegistra);
    }

    public function setUserRegistra(?string $value): static
    {
        $this->userRegistra = RemoveXss($value);
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

    public function getExpediente(): ?string
    {
        return $this->expediente;
    }

    public function setExpediente(?string $value): static
    {
        $this->expediente = $value;
        return $this;
    }

    public function getReligion(): ?string
    {
        return HtmlDecode($this->religion);
    }

    public function setReligion(?string $value): static
    {
        $this->religion = RemoveXss($value);
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

    public function getServicio(): ?string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(?string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }

    public function getEstatus(): ?int
    {
        return $this->estatus;
    }

    public function setEstatus(?int $value): static
    {
        $this->estatus = $value;
        return $this;
    }

    public function getFuneraria(): ?int
    {
        return $this->funeraria;
    }

    public function setFuneraria(?int $value): static
    {
        $this->funeraria = $value;
        return $this;
    }
}
