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
 * Entity class for "sco_chat" table
 */
#[Entity]
#[Table(name: "sco_chat")]
class ScoChat extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nchat", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nchat;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "string", nullable: true)]
    private ?string $texto;

    #[Column(name: "a_username", type: "string", nullable: true)]
    private ?string $aUsername;

    #[Column(type: "string", nullable: true)]
    private ?string $leido;

    public function __construct()
    {
        $this->username = "0";
        $this->texto = "0";
        $this->aUsername = "0";
        $this->leido = "N";
    }

    public function getNchat(): int
    {
        return $this->nchat;
    }

    public function setNchat(int $value): static
    {
        $this->nchat = $value;
        return $this;
    }

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
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

    public function getTexto(): ?string
    {
        return HtmlDecode($this->texto);
    }

    public function setTexto(?string $value): static
    {
        $this->texto = RemoveXss($value);
        return $this;
    }

    public function getAUsername(): ?string
    {
        return HtmlDecode($this->aUsername);
    }

    public function setAUsername(?string $value): static
    {
        $this->aUsername = RemoveXss($value);
        return $this;
    }

    public function getLeido(): ?string
    {
        return HtmlDecode($this->leido);
    }

    public function setLeido(?string $value): static
    {
        $this->leido = RemoveXss($value);
        return $this;
    }
}
