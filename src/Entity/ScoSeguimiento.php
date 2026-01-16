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
 * Entity class for "sco_seguimiento" table
 */
#[Entity]
#[Table(name: "sco_seguimiento")]
class ScoSeguimiento extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nseguimiento", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nseguimiento;

    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(type: "string")]
    private string $username;

    #[Column(name: "user_asigna", type: "string")]
    private string $userAsigna;

    #[Column(type: "datetime")]
    private DateTime $fecha;

    #[Column(type: "text")]
    private string $texto;

    #[Column(type: "integer")]
    private int $alertar;

    #[Column(name: "texto_cierre", type: "text")]
    private string $textoCierre;

    #[Column(name: "fecha_cierre", type: "datetime")]
    private DateTime $fechaCierre;

    #[Column(type: "integer")]
    private int $estatus;

    public function __construct()
    {
        $this->alertar = 1;
        $this->estatus = 0;
    }

    public function getNseguimiento(): string
    {
        return $this->nseguimiento;
    }

    public function setNseguimiento(string $value): static
    {
        $this->nseguimiento = $value;
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

    public function getUsername(): string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getUserAsigna(): string
    {
        return HtmlDecode($this->userAsigna);
    }

    public function setUserAsigna(string $value): static
    {
        $this->userAsigna = RemoveXss($value);
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }

    public function getTexto(): string
    {
        return HtmlDecode($this->texto);
    }

    public function setTexto(string $value): static
    {
        $this->texto = RemoveXss($value);
        return $this;
    }

    public function getAlertar(): int
    {
        return $this->alertar;
    }

    public function setAlertar(int $value): static
    {
        $this->alertar = $value;
        return $this;
    }

    public function getTextoCierre(): string
    {
        return HtmlDecode($this->textoCierre);
    }

    public function setTextoCierre(string $value): static
    {
        $this->textoCierre = RemoveXss($value);
        return $this;
    }

    public function getFechaCierre(): DateTime
    {
        return $this->fechaCierre;
    }

    public function setFechaCierre(DateTime $value): static
    {
        $this->fechaCierre = $value;
        return $this;
    }

    public function getEstatus(): int
    {
        return $this->estatus;
    }

    public function setEstatus(int $value): static
    {
        $this->estatus = $value;
        return $this;
    }
}
