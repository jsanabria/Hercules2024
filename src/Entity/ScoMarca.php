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
 * Entity class for "sco_marca" table
 */
#[Entity]
#[Table(name: "sco_marca")]
class ScoMarca extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmarca", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nmarca;

    #[Column(type: "string", unique: true)]
    private string $nombre;

    #[Column(type: "integer")]
    private int $activo;

    public function __construct()
    {
        $this->nombre = "0";
        $this->activo = 1;
    }

    public function getNmarca(): int
    {
        return $this->nmarca;
    }

    public function setNmarca(int $value): static
    {
        $this->nmarca = $value;
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
