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
 * Entity class for "sco_ofrece_servicio" table
 */
#[Entity]
#[Table(name: "sco_ofrece_servicio")]
class ScoOfreceServicio extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nfrece_servicio", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nfreceServicio;

    #[Column(type: "integer")]
    private int $proveedor;

    #[Column(type: "string")]
    private string $tipo;

    #[Column(type: "string")]
    private string $servicio;

    public function getNfreceServicio(): int
    {
        return $this->nfreceServicio;
    }

    public function setNfreceServicio(int $value): static
    {
        $this->nfreceServicio = $value;
        return $this;
    }

    public function getProveedor(): int
    {
        return $this->proveedor;
    }

    public function setProveedor(int $value): static
    {
        $this->proveedor = $value;
        return $this;
    }

    public function getTipo(): string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }

    public function getServicio(): string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }
}
