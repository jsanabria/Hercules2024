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
 * Entity class for "sco_reserva" table
 */
#[Entity]
#[Table(name: "sco_reserva")]
class ScoReserva extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    #[Column(type: "string")]
    private string $capilla;

    #[Column(name: "fecha_inicio", type: "datetime")]
    private DateTime $fechaInicio;

    #[Column(name: "hora_inicio", type: "time")]
    private DateTime $horaInicio;

    #[Column(name: "user_registra", type: "string", nullable: true)]
    private ?string $userRegistra;

    #[Column(type: "string")]
    private string $localidad;

    #[Column(name: "fecha_fin", type: "datetime")]
    private DateTime $fechaFin;

    #[Column(name: "hora_fin", type: "time")]
    private DateTime $horaFin;

    #[Column(type: "string", nullable: true)]
    private ?string $motivo;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getCapilla(): string
    {
        return HtmlDecode($this->capilla);
    }

    public function setCapilla(string $value): static
    {
        $this->capilla = RemoveXss($value);
        return $this;
    }

    public function getFechaInicio(): DateTime
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(DateTime $value): static
    {
        $this->fechaInicio = $value;
        return $this;
    }

    public function getHoraInicio(): DateTime
    {
        return $this->horaInicio;
    }

    public function setHoraInicio(DateTime $value): static
    {
        $this->horaInicio = $value;
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

    public function getLocalidad(): string
    {
        return HtmlDecode($this->localidad);
    }

    public function setLocalidad(string $value): static
    {
        $this->localidad = RemoveXss($value);
        return $this;
    }

    public function getFechaFin(): DateTime
    {
        return $this->fechaFin;
    }

    public function setFechaFin(DateTime $value): static
    {
        $this->fechaFin = $value;
        return $this;
    }

    public function getHoraFin(): DateTime
    {
        return $this->horaFin;
    }

    public function setHoraFin(DateTime $value): static
    {
        $this->horaFin = $value;
        return $this;
    }

    public function getMotivo(): ?string
    {
        return HtmlDecode($this->motivo);
    }

    public function setMotivo(?string $value): static
    {
        $this->motivo = RemoveXss($value);
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
