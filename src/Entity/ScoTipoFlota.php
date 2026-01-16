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
 * Entity class for "sco_tipo_flota" table
 */
#[Entity]
#[Table(name: "sco_tipo_flota")]
class ScoTipoFlota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ntipo_flota", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ntipoFlota;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    public function getNtipoFlota(): int
    {
        return $this->ntipoFlota;
    }

    public function setNtipoFlota(int $value): static
    {
        $this->ntipoFlota = $value;
        return $this;
    }

    public function getNombre(): ?string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(?string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }
}
