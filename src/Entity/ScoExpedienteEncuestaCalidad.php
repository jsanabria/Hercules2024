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
 * Entity class for "sco_expediente_encuesta_calidad" table
 */
#[Entity]
#[Table(name: "sco_expediente_encuesta_calidad")]
class ScoExpedienteEncuestaCalidad extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente_encuesta_calidad", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nexpedienteEncuestaCalidad;

    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(type: "text", nullable: true)]
    private ?string $pregunta;

    #[Column(type: "string", nullable: true)]
    private ?string $respuesta;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    public function __construct()
    {
        $this->expediente = "0";
    }

    public function getNexpedienteEncuestaCalidad(): string
    {
        return $this->nexpedienteEncuestaCalidad;
    }

    public function setNexpedienteEncuestaCalidad(string $value): static
    {
        $this->nexpedienteEncuestaCalidad = $value;
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

    public function getPregunta(): ?string
    {
        return HtmlDecode($this->pregunta);
    }

    public function setPregunta(?string $value): static
    {
        $this->pregunta = RemoveXss($value);
        return $this;
    }

    public function getRespuesta(): ?string
    {
        return HtmlDecode($this->respuesta);
    }

    public function setRespuesta(?string $value): static
    {
        $this->respuesta = RemoveXss($value);
        return $this;
    }

    public function getFechaHora(): ?DateTime
    {
        return $this->fechaHora;
    }

    public function setFechaHora(?DateTime $value): static
    {
        $this->fechaHora = $value;
        return $this;
    }
}
