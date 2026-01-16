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
 * Entity class for "view_expediente" table
 */
#[Entity]
#[Table(name: "view_expediente")]
class ViewExpediente extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente", type: "bigint")]
    #[GeneratedValue]
    private string $nexpediente;

    #[Column(name: "cedula_fallecido", type: "string", nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellidos_fallecido", type: "string", nullable: true)]
    private ?string $apellidosFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $permiso;

    #[Column(type: "string", nullable: true)]
    private ?string $capilla;

    #[Column(name: "fecha_inicio", type: "datetime", nullable: true)]
    private ?DateTime $fechaInicio;

    #[Column(name: "hora_inicio", type: "string", nullable: true)]
    private ?string $horaInicio;

    #[Column(name: "fecha_fin", type: "datetime", nullable: true)]
    private ?DateTime $fechaFin;

    #[Column(name: "hora_fin", type: "string", nullable: true)]
    private ?string $horaFin;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(name: "fecha_serv", type: "datetime", nullable: true)]
    private ?DateTime $fechaServ;

    #[Column(name: "hora_serv", type: "string", nullable: true)]
    private ?string $horaServ;

    #[Column(name: "espera_cenizas", type: "string", nullable: true)]
    private ?string $esperaCenizas;

    #[Column(name: "hora_fin_capilla", type: "time", nullable: true)]
    private ?DateTime $horaFinCapilla;

    #[Column(name: "hora_fin_servicio", type: "time", nullable: true)]
    private ?DateTime $horaFinServicio;

    public function __construct()
    {
        $this->esperaCenizas = "N";
    }

    public function getNexpediente(): string
    {
        return $this->nexpediente;
    }

    public function setNexpediente(string $value): static
    {
        $this->nexpediente = $value;
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

    public function getPermiso(): ?string
    {
        return HtmlDecode($this->permiso);
    }

    public function setPermiso(?string $value): static
    {
        $this->permiso = RemoveXss($value);
        return $this;
    }

    public function getCapilla(): ?string
    {
        return HtmlDecode($this->capilla);
    }

    public function setCapilla(?string $value): static
    {
        $this->capilla = RemoveXss($value);
        return $this;
    }

    public function getFechaInicio(): ?DateTime
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(?DateTime $value): static
    {
        $this->fechaInicio = $value;
        return $this;
    }

    public function getHoraInicio(): ?string
    {
        return HtmlDecode($this->horaInicio);
    }

    public function setHoraInicio(?string $value): static
    {
        $this->horaInicio = RemoveXss($value);
        return $this;
    }

    public function getFechaFin(): ?DateTime
    {
        return $this->fechaFin;
    }

    public function setFechaFin(?DateTime $value): static
    {
        $this->fechaFin = $value;
        return $this;
    }

    public function getHoraFin(): ?string
    {
        return HtmlDecode($this->horaFin);
    }

    public function setHoraFin(?string $value): static
    {
        $this->horaFin = RemoveXss($value);
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

    public function getFechaServ(): ?DateTime
    {
        return $this->fechaServ;
    }

    public function setFechaServ(?DateTime $value): static
    {
        $this->fechaServ = $value;
        return $this;
    }

    public function getHoraServ(): ?string
    {
        return HtmlDecode($this->horaServ);
    }

    public function setHoraServ(?string $value): static
    {
        $this->horaServ = RemoveXss($value);
        return $this;
    }

    public function getEsperaCenizas(): ?string
    {
        return HtmlDecode($this->esperaCenizas);
    }

    public function setEsperaCenizas(?string $value): static
    {
        $this->esperaCenizas = RemoveXss($value);
        return $this;
    }

    public function getHoraFinCapilla(): ?DateTime
    {
        return $this->horaFinCapilla;
    }

    public function setHoraFinCapilla(?DateTime $value): static
    {
        $this->horaFinCapilla = $value;
        return $this;
    }

    public function getHoraFinServicio(): ?DateTime
    {
        return $this->horaFinServicio;
    }

    public function setHoraFinServicio(?DateTime $value): static
    {
        $this->horaFinServicio = $value;
        return $this;
    }
}
