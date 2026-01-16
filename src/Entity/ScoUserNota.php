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
 * Entity class for "sco_user_nota" table
 */
#[Entity]
#[Table(name: "sco_user_nota")]
class ScoUserNota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nuser_nota", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nuserNota;

    #[Column(type: "integer", nullable: true)]
    private ?int $user;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "text", nullable: true)]
    private ?string $nota;

    public function getNuserNota(): int
    {
        return $this->nuserNota;
    }

    public function setNuserNota(int $value): static
    {
        $this->nuserNota = $value;
        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $value): static
    {
        $this->user = $value;
        return $this;
    }

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
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
}
