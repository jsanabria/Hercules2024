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
 * Entity class for "sco_funciones" table
 */
#[Entity]
#[Table(name: "sco_funciones")]
class ScoFuncione extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nfuncion", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nfuncion;

    #[Column(type: "string", unique: true, nullable: true)]
    private ?string $codigo;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    public function getNfuncion(): int
    {
        return $this->nfuncion;
    }

    public function setNfuncion(int $value): static
    {
        $this->nfuncion = $value;
        return $this;
    }

    public function getCodigo(): ?string
    {
        return HtmlDecode($this->codigo);
    }

    public function setCodigo(?string $value): static
    {
        $this->codigo = RemoveXss($value);
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
