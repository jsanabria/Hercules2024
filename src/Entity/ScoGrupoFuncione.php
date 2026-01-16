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
 * Entity class for "sco_grupo_funciones" table
 */
#[Entity]
#[Table(name: "sco_grupo_funciones")]
class ScoGrupoFuncione extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ngrupo_funciones", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ngrupoFunciones;

    #[Column(type: "integer", nullable: true)]
    private ?int $grupo;

    #[Column(type: "integer", nullable: true)]
    private ?int $funcion;

    public function getNgrupoFunciones(): int
    {
        return $this->ngrupoFunciones;
    }

    public function setNgrupoFunciones(int $value): static
    {
        $this->ngrupoFunciones = $value;
        return $this;
    }

    public function getGrupo(): ?int
    {
        return $this->grupo;
    }

    public function setGrupo(?int $value): static
    {
        $this->grupo = $value;
        return $this;
    }

    public function getFuncion(): ?int
    {
        return $this->funcion;
    }

    public function setFuncion(?int $value): static
    {
        $this->funcion = $value;
        return $this;
    }
}
