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
 * Entity class for "view_expediente_funeraria" table
 */
#[Entity]
#[Table(name: "view_expediente_funeraria")]
class ViewExpedienteFuneraria extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden", type: "bigint")]
    private string $norden;

    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(name: "cedula_fallecido", type: "string", nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellidos_fallecido", type: "string", nullable: true)]
    private ?string $apellidosFallecido;

    #[Column(name: "causa_ocurrencia", type: "string", nullable: true)]
    private ?string $causaOcurrencia;

    #[Column(name: "fecha_servicio", type: "datetime", nullable: true)]
    private ?DateTime $fechaServicio;

    #[Column(name: "hora_fin", type: "time", nullable: true)]
    private ?DateTime $horaFin;

    #[Column(type: "integer", nullable: true)]
    private ?int $funeraria;

    #[Column(name: "user_registra", type: "string", nullable: true)]
    private ?string $userRegistra;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    public function __construct()
    {
        $this->norden = "0";
    }

    public function getNorden(): string
    {
        return $this->norden;
    }

    public function setNorden(string $value): static
    {
        $this->norden = $value;
        return $this;
    }

    public function getExpediente(): string
    {
        return $this->expediente;
    }

    public function setExpediente(string $value): static
    {
        $this->expediente = $value;
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

    public function getCausaOcurrencia(): ?string
    {
        return HtmlDecode($this->causaOcurrencia);
    }

    public function setCausaOcurrencia(?string $value): static
    {
        $this->causaOcurrencia = RemoveXss($value);
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

    public function getHoraFin(): ?DateTime
    {
        return $this->horaFin;
    }

    public function setHoraFin(?DateTime $value): static
    {
        $this->horaFin = $value;
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
}
