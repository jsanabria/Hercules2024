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
 * Entity class for "sco_parametro" table
 */
#[Entity]
#[Table(name: "sco_parametro")]
class ScoParametro extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nparametro", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nparametro;

    #[Column(type: "string", nullable: true)]
    private ?string $codigo;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "string", nullable: true)]
    private ?string $valor1;

    #[Column(type: "string", nullable: true)]
    private ?string $valor2;

    #[Column(type: "string", nullable: true)]
    private ?string $valor3;

    #[Column(type: "string", nullable: true)]
    private ?string $valor4;

    public function getNparametro(): int
    {
        return $this->nparametro;
    }

    public function setNparametro(int $value): static
    {
        $this->nparametro = $value;
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

    public function getDescripcion(): ?string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(?string $value): static
    {
        $this->descripcion = RemoveXss($value);
        return $this;
    }

    public function getValor1(): ?string
    {
        return HtmlDecode($this->valor1);
    }

    public function setValor1(?string $value): static
    {
        $this->valor1 = RemoveXss($value);
        return $this;
    }

    public function getValor2(): ?string
    {
        return HtmlDecode($this->valor2);
    }

    public function setValor2(?string $value): static
    {
        $this->valor2 = RemoveXss($value);
        return $this;
    }

    public function getValor3(): ?string
    {
        return HtmlDecode($this->valor3);
    }

    public function setValor3(?string $value): static
    {
        $this->valor3 = RemoveXss($value);
        return $this;
    }

    public function getValor4(): ?string
    {
        return HtmlDecode($this->valor4);
    }

    public function setValor4(?string $value): static
    {
        $this->valor4 = RemoveXss($value);
        return $this;
    }
}
