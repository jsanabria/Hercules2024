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
 * Entity class for "sco_sms_qwerty" table
 */
#[Entity]
#[Table(name: "sco_sms_qwerty")]
class ScoSmsQwerty extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nsms_qwerty", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nsmsQwerty;

    #[Column(type: "string", nullable: true)]
    private ?string $celular;

    #[Column(type: "string", nullable: true)]
    private ?string $comando;

    #[Column(type: "string", nullable: true)]
    private ?string $cedula;

    #[Column(type: "string", nullable: true)]
    private ?string $titular;

    #[Column(type: "string", nullable: true)]
    private ?string $texto;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    public function getNsmsQwerty(): string
    {
        return $this->nsmsQwerty;
    }

    public function setNsmsQwerty(string $value): static
    {
        $this->nsmsQwerty = $value;
        return $this;
    }

    public function getCelular(): ?string
    {
        return HtmlDecode($this->celular);
    }

    public function setCelular(?string $value): static
    {
        $this->celular = RemoveXss($value);
        return $this;
    }

    public function getComando(): ?string
    {
        return HtmlDecode($this->comando);
    }

    public function setComando(?string $value): static
    {
        $this->comando = RemoveXss($value);
        return $this;
    }

    public function getCedula(): ?string
    {
        return HtmlDecode($this->cedula);
    }

    public function setCedula(?string $value): static
    {
        $this->cedula = RemoveXss($value);
        return $this;
    }

    public function getTitular(): ?string
    {
        return HtmlDecode($this->titular);
    }

    public function setTitular(?string $value): static
    {
        $this->titular = RemoveXss($value);
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

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }
}
