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
 * Entity class for "sco_embalaje" table
 */
#[Entity]
#[Table(name: "sco_embalaje")]
class ScoEmbalaje extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nembalaje", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nembalaje;

    #[Column(type: "bigint", nullable: true)]
    private ?string $expediente;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $precinto1;

    #[Column(type: "string", nullable: true)]
    private ?string $precinto2;

    #[Column(name: "nombre_familiar", type: "string", nullable: true)]
    private ?string $nombreFamiliar;

    #[Column(name: "cedula_familiar", type: "string", nullable: true)]
    private ?string $cedulaFamiliar;

    #[Column(name: "certificado_defuncion", type: "string", nullable: true)]
    private ?string $certificadoDefuncion;

    #[Column(name: "fecha_servicio", type: "date", nullable: true)]
    private ?DateTime $fechaServicio;

    #[Column(type: "string", nullable: true)]
    private ?string $doctor;

    #[Column(name: "doctor_nro", type: "string", nullable: true)]
    private ?string $doctorNro;

    #[Column(name: "cremacion_nro", type: "string", nullable: true)]
    private ?string $cremacionNro;

    #[Column(name: "registro_civil", type: "string", nullable: true)]
    private ?string $registroCivil;

    #[Column(name: "dimension_cofre", type: "string", nullable: true)]
    private ?string $dimensionCofre;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "string", nullable: true)]
    private ?string $anulado;

    public function __construct()
    {
        $this->anulado = "N";
    }

    public function getNembalaje(): string
    {
        return $this->nembalaje;
    }

    public function setNembalaje(string $value): static
    {
        $this->nembalaje = $value;
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

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }

    public function getPrecinto1(): ?string
    {
        return HtmlDecode($this->precinto1);
    }

    public function setPrecinto1(?string $value): static
    {
        $this->precinto1 = RemoveXss($value);
        return $this;
    }

    public function getPrecinto2(): ?string
    {
        return HtmlDecode($this->precinto2);
    }

    public function setPrecinto2(?string $value): static
    {
        $this->precinto2 = RemoveXss($value);
        return $this;
    }

    public function getNombreFamiliar(): ?string
    {
        return HtmlDecode($this->nombreFamiliar);
    }

    public function setNombreFamiliar(?string $value): static
    {
        $this->nombreFamiliar = RemoveXss($value);
        return $this;
    }

    public function getCedulaFamiliar(): ?string
    {
        return HtmlDecode($this->cedulaFamiliar);
    }

    public function setCedulaFamiliar(?string $value): static
    {
        $this->cedulaFamiliar = RemoveXss($value);
        return $this;
    }

    public function getCertificadoDefuncion(): ?string
    {
        return HtmlDecode($this->certificadoDefuncion);
    }

    public function setCertificadoDefuncion(?string $value): static
    {
        $this->certificadoDefuncion = RemoveXss($value);
        return $this;
    }

    public function getFechaServicio(): ?DateTime
    {
        return $this->fechaServicio;
    }

    public function setFechaServicio(?DateTime $value): static
    {
        $this->fechaServicio = $value;
        return $this;
    }

    public function getDoctor(): ?string
    {
        return HtmlDecode($this->doctor);
    }

    public function setDoctor(?string $value): static
    {
        $this->doctor = RemoveXss($value);
        return $this;
    }

    public function getDoctorNro(): ?string
    {
        return HtmlDecode($this->doctorNro);
    }

    public function setDoctorNro(?string $value): static
    {
        $this->doctorNro = RemoveXss($value);
        return $this;
    }

    public function getCremacionNro(): ?string
    {
        return HtmlDecode($this->cremacionNro);
    }

    public function setCremacionNro(?string $value): static
    {
        $this->cremacionNro = RemoveXss($value);
        return $this;
    }

    public function getRegistroCivil(): ?string
    {
        return HtmlDecode($this->registroCivil);
    }

    public function setRegistroCivil(?string $value): static
    {
        $this->registroCivil = RemoveXss($value);
        return $this;
    }

    public function getDimensionCofre(): ?string
    {
        return HtmlDecode($this->dimensionCofre);
    }

    public function setDimensionCofre(?string $value): static
    {
        $this->dimensionCofre = RemoveXss($value);
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

    public function getAnulado(): ?string
    {
        return $this->anulado;
    }

    public function setAnulado(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'anulado' value");
        }
        $this->anulado = $value;
        return $this;
    }
}
