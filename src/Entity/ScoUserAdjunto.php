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
 * Entity class for "sco_user_adjunto" table
 */
#[Entity]
#[Table(name: "sco_user_adjunto")]
class ScoUserAdjunto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nuser_adjunto", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nuserAdjunto;

    #[Column(type: "bigint")]
    private string $user;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $archivo;

    public function __construct()
    {
        $this->user = "0";
    }

    public function getNuserAdjunto(): string
    {
        return $this->nuserAdjunto;
    }

    public function setNuserAdjunto(string $value): static
    {
        $this->nuserAdjunto = $value;
        return $this;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $value): static
    {
        $this->user = $value;
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

    public function getArchivo(): ?string
    {
        return HtmlDecode($this->archivo);
    }

    public function setArchivo(?string $value): static
    {
        $this->archivo = RemoveXss($value);
        return $this;
    }
}
