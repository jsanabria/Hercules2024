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
 * Entity class for "sco_articulo" table
 */
#[Entity]
#[Table(name: "sco_articulo")]
class ScoArticulo extends AbstractEntity
{
    #[Id]
    #[Column(name: "Narticulo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $narticulo;

    #[Column(name: "tipo_insumo", type: "string", nullable: true)]
    private ?string $tipoInsumo;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    public function getNarticulo(): int
    {
        return $this->narticulo;
    }

    public function setNarticulo(int $value): static
    {
        $this->narticulo = $value;
        return $this;
    }

    public function getTipoInsumo(): ?string
    {
        return HtmlDecode($this->tipoInsumo);
    }

    public function setTipoInsumo(?string $value): static
    {
        $this->tipoInsumo = RemoveXss($value);
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(?string $value): static
    {
        $this->descripcion = RemoveXss($value);
        return $this;
    }
}
