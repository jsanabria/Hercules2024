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
 * Entity class for "sco_encuesta_calidad" table
 */
#[Entity]
#[Table(name: "sco_encuesta_calidad")]
class ScoEncuestaCalidad extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nencuesta_calidad", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nencuestaCalidad;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "text", nullable: true)]
    private ?string $pregunta;

    #[Column(type: "text", nullable: true)]
    private ?string $respuesta;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    public function __construct()
    {
        $this->activo = "N";
    }

    public function getNencuestaCalidad(): string
    {
        return $this->nencuestaCalidad;
    }

    public function setNencuestaCalidad(string $value): static
    {
        $this->nencuestaCalidad = $value;
        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $value): static
    {
        if (!in_array($value, ["PREGUNTA", "ENUNCIADO"])) {
            throw new \InvalidArgumentException("Invalid 'tipo' value");
        }
        $this->tipo = $value;
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

    public function getActivo(): ?string
    {
        return $this->activo;
    }

    public function setActivo(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'activo' value");
        }
        $this->activo = $value;
        return $this;
    }
}
