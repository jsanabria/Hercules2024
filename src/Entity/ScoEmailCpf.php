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
 * Entity class for "sco_email_cpf" table
 */
#[Entity]
#[Table(name: "sco_email_cpf")]
class ScoEmailCpf extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nemail_cpf", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nemailCpf;

    #[Column(type: "bigint", nullable: true)]
    private ?string $expediente;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    #[Column(type: "string", unique: true, nullable: true)]
    private ?string $codigo;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function getNemailCpf(): string
    {
        return $this->nemailCpf;
    }

    public function setNemailCpf(string $value): static
    {
        $this->nemailCpf = $value;
        return $this;
    }

    public function getExpediente(): ?string
    {
        return $this->expediente;
    }

    public function setExpediente(?string $value): static
    {
        $this->expediente = $value;
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

    public function getCodigo(): ?string
    {
        return HtmlDecode($this->codigo);
    }

    public function setCodigo(?string $value): static
    {
        $this->codigo = RemoveXss($value);
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getEstatus(): ?string
    {
        return $this->estatus;
    }

    public function setEstatus(?string $value): static
    {
        if (!in_array($value, ["ENVIADO", "PROCESADO"])) {
            throw new \InvalidArgumentException("Invalid 'estatus' value");
        }
        $this->estatus = $value;
        return $this;
    }
}
