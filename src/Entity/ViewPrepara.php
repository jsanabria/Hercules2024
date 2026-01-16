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
 * Entity class for "view_prepara" table
 */
#[Entity]
#[Table(name: "view_prepara")]
class ViewPrepara extends AbstractEntity
{
    #[Column(name: "Nexpediente", type: "bigint")]
    private string $nexpediente;

    #[Column(type: "string", nullable: true)]
    private ?string $difunto;

    #[Column(type: "string", nullable: true)]
    private ?string $capilla;

    #[Column(name: "tipo_servicio", type: "string", nullable: true)]
    private ?string $tipoServicio;

    #[Column(type: "string", nullable: true)]
    private ?string $ataud;

    #[Column(name: "fecha_inicio", type: "datetime", nullable: true)]
    private ?DateTime $fechaInicio;

    #[Column(name: "hora_inicio", type: "string", nullable: true)]
    private ?string $horaInicio;

    #[Column(name: "fecha_fin", type: "datetime", nullable: true)]
    private ?DateTime $fechaFin;

    #[Column(name: "hora_fin", type: "string", nullable: true)]
    private ?string $horaFin;

    #[Column(name: "fecha_sepelio", type: "datetime", nullable: true)]
    private ?DateTime $fechaSepelio;

    #[Column(name: "hora_sepelio", type: "string", nullable: true)]
    private ?string $horaSepelio;

    #[Column(type: "integer", nullable: true)]
    private ?int $estatus;

    #[Column(name: "fecha_ofirel", type: "datetime", nullable: true)]
    private ?DateTime $fechaOfirel;

    #[Column(name: "hora_ofirel", type: "string", nullable: true)]
    private ?string $horaOfirel;

    #[Column(type: "integer", nullable: true)]
    private ?int $funeraria;

    public function __construct()
    {
        $this->nexpediente = "0";
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

    public function getDifunto(): ?string
    {
        return HtmlDecode($this->difunto);
    }

    public function setDifunto(?string $value): static
    {
        $this->difunto = RemoveXss($value);
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

    public function getTipoServicio(): ?string
    {
        return HtmlDecode($this->tipoServicio);
    }

    public function setTipoServicio(?string $value): static
    {
        $this->tipoServicio = RemoveXss($value);
        return $this;
    }

    public function getAtaud(): ?string
    {
        return HtmlDecode($this->ataud);
    }

    public function setAtaud(?string $value): static
    {
        $this->ataud = RemoveXss($value);
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

    public function getFechaSepelio(): ?DateTime
    {
        return $this->fechaSepelio;
    }

    public function setFechaSepelio(?DateTime $value): static
    {
        $this->fechaSepelio = $value;
        return $this;
    }

    public function getHoraSepelio(): ?string
    {
        return HtmlDecode($this->horaSepelio);
    }

    public function setHoraSepelio(?string $value): static
    {
        $this->horaSepelio = RemoveXss($value);
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

    public function getFechaOfirel(): ?DateTime
    {
        return $this->fechaOfirel;
    }

    public function setFechaOfirel(?DateTime $value): static
    {
        $this->fechaOfirel = $value;
        return $this;
    }

    public function getHoraOfirel(): ?string
    {
        return HtmlDecode($this->horaOfirel);
    }

    public function setHoraOfirel(?string $value): static
    {
        $this->horaOfirel = RemoveXss($value);
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
