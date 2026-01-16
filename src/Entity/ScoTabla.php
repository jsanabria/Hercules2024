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
 * Entity class for "sco_tabla" table
 */
#[Entity]
#[Table(name: "sco_tabla")]
class ScoTabla extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ntabla", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ntabla;

    #[Column(type: "string", nullable: true)]
    private ?string $tabla;

    #[Column(name: "campo_codigo", type: "string", unique: true, nullable: true)]
    private ?string $campoCodigo;

    #[Column(name: "campo_descripcion", type: "string", nullable: true)]
    private ?string $campoDescripcion;

    public function getNtabla(): int
    {
        return $this->ntabla;
    }

    public function setNtabla(int $value): static
    {
        $this->ntabla = $value;
        return $this;
    }

    public function getTabla(): ?string
    {
        return HtmlDecode($this->tabla);
    }

    public function setTabla(?string $value): static
    {
        $this->tabla = RemoveXss($value);
        return $this;
    }

    public function getCampoCodigo(): ?string
    {
        return HtmlDecode($this->campoCodigo);
    }

    public function setCampoCodigo(?string $value): static
    {
        $this->campoCodigo = RemoveXss($value);
        return $this;
    }

    public function getCampoDescripcion(): ?string
    {
        return HtmlDecode($this->campoDescripcion);
    }

    public function setCampoDescripcion(?string $value): static
    {
        $this->campoDescripcion = RemoveXss($value);
        return $this;
    }
}
