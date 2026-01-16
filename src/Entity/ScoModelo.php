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
 * Entity class for "sco_modelo" table
 */
#[Entity]
#[Table(name: "sco_modelo")]
class ScoModelo extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmodelo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nmodelo;

    #[Column(type: "integer")]
    private int $tipo;

    #[Column(type: "integer")]
    private int $marca;

    #[Column(type: "string")]
    private string $nombre;

    #[Column(type: "integer")]
    private int $activo;

    public function __construct()
    {
        $this->tipo = 0;
        $this->marca = 0;
        $this->nombre = "0";
        $this->activo = 1;
    }

    public function getNmodelo(): int
    {
        return $this->nmodelo;
    }

    public function setNmodelo(int $value): static
    {
        $this->nmodelo = $value;
        return $this;
    }

    public function getTipo(): int
    {
        return $this->tipo;
    }

    public function setTipo(int $value): static
    {
        $this->tipo = $value;
        return $this;
    }

    public function getMarca(): int
    {
        return $this->marca;
    }

    public function setMarca(int $value): static
    {
        $this->marca = $value;
        return $this;
    }

    public function getNombre(): string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getActivo(): int
    {
        return $this->activo;
    }

    public function setActivo(int $value): static
    {
        $this->activo = $value;
        return $this;
    }
}
