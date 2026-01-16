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
 * Entity class for "userlevels" table
 */
#[Entity]
#[Table(name: "userlevels")]
class Userlevel extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    private int $userlevelid;

    #[Column(type: "string")]
    private string $userlevelname;

    #[Column(type: "integer")]
    private int $color;

    #[Column(type: "string")]
    private string $reserva;

    #[Column(type: "string")]
    private string $indicador;

    #[Column(name: "tipo_proveedor", type: "integer")]
    private int $tipoProveedor;

    #[Column(name: "ver_alertas", type: "string")]
    private string $verAlertas;

    #[Column(type: "string")]
    private string $financiero;

    public function __construct()
    {
        $this->color = 0;
        $this->reserva = "S";
        $this->indicador = "S";
        $this->tipoProveedor = 0;
        $this->verAlertas = "S";
        $this->financiero = "S";
    }

    public function getUserlevelid(): int
    {
        return $this->userlevelid;
    }

    public function setUserlevelid(int $value): static
    {
        $this->userlevelid = $value;
        return $this;
    }

    public function getUserlevelname(): string
    {
        return HtmlDecode($this->userlevelname);
    }

    public function setUserlevelname(string $value): static
    {
        $this->userlevelname = RemoveXss($value);
        return $this;
    }

    public function getColor(): int
    {
        return $this->color;
    }

    public function setColor(int $value): static
    {
        $this->color = $value;
        return $this;
    }

    public function getReserva(): string
    {
        return $this->reserva;
    }

    public function setReserva(string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'reserva' value");
        }
        $this->reserva = $value;
        return $this;
    }

    public function getIndicador(): string
    {
        return $this->indicador;
    }

    public function setIndicador(string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'indicador' value");
        }
        $this->indicador = $value;
        return $this;
    }

    public function getTipoProveedor(): int
    {
        return $this->tipoProveedor;
    }

    public function setTipoProveedor(int $value): static
    {
        $this->tipoProveedor = $value;
        return $this;
    }

    public function getVerAlertas(): string
    {
        return $this->verAlertas;
    }

    public function setVerAlertas(string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'ver_alertas' value");
        }
        $this->verAlertas = $value;
        return $this;
    }

    public function getFinanciero(): string
    {
        return $this->financiero;
    }

    public function setFinanciero(string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'financiero' value");
        }
        $this->financiero = $value;
        return $this;
    }
}
