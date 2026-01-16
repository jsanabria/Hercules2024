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
 * Entity class for "sco_parcela_ventas_nota" table
 */
#[Entity]
#[Table(name: "sco_parcela_ventas_nota")]
class ScoParcelaVentasNota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nparcela_ventas_nota", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nparcelaVentasNota;

    #[Column(name: "parcela_ventas", type: "integer", nullable: true)]
    private ?int $parcelaVentas;

    #[Column(type: "text", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    public function getNparcelaVentasNota(): int
    {
        return $this->nparcelaVentasNota;
    }

    public function setNparcelaVentasNota(int $value): static
    {
        $this->nparcelaVentasNota = $value;
        return $this;
    }

    public function getParcelaVentas(): ?int
    {
        return $this->parcelaVentas;
    }

    public function setParcelaVentas(?int $value): static
    {
        $this->parcelaVentas = $value;
        return $this;
    }

    public function getNota(): ?string
    {
        return HtmlDecode($this->nota);
    }

    public function setNota(?string $value): static
    {
        $this->nota = RemoveXss($value);
        return $this;
    }

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getFechaHora(): ?DateTime
    {
        return $this->fechaHora;
    }

    public function setFechaHora(?DateTime $value): static
    {
        $this->fechaHora = $value;
        return $this;
    }
}
