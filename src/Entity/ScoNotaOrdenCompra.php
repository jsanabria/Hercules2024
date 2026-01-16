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
 * Entity class for "sco_nota_orden_compra" table
 */
#[Entity]
#[Table(name: "sco_nota_orden_compra")]
class ScoNotaOrdenCompra extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nnota_orden_compra", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nnotaOrdenCompra;

    #[Column(name: "orden_compra", type: "bigint")]
    private string $ordenCompra;

    #[Column(type: "text")]
    private string $nota;

    #[Column(type: "string")]
    private string $usuario;

    #[Column(type: "datetime")]
    private DateTime $fecha;

    public function getNnotaOrdenCompra(): string
    {
        return $this->nnotaOrdenCompra;
    }

    public function setNnotaOrdenCompra(string $value): static
    {
        $this->nnotaOrdenCompra = $value;
        return $this;
    }

    public function getOrdenCompra(): string
    {
        return $this->ordenCompra;
    }

    public function setOrdenCompra(string $value): static
    {
        $this->ordenCompra = $value;
        return $this;
    }

    public function getNota(): string
    {
        return HtmlDecode($this->nota);
    }

    public function setNota(string $value): static
    {
        $this->nota = RemoveXss($value);
        return $this;
    }

    public function getUsuario(): string
    {
        return HtmlDecode($this->usuario);
    }

    public function setUsuario(string $value): static
    {
        $this->usuario = RemoveXss($value);
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }
}
