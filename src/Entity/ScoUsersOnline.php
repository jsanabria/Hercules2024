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
 * Entity class for "sco_users_online" table
 */
#[Entity]
#[Table(name: "sco_users_online")]
class ScoUsersOnline extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $unlogin;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Id]
    #[Column(type: "integer", unique: true)]
    private int $timestamp;

    #[Column(type: "string")]
    private string $ip;

    #[Column(type: "string")]
    private string $file;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $updated;

    #[Column(name: "last_activity", type: "datetime", nullable: true)]
    private ?DateTime $lastActivity;

    public function __construct()
    {
        $this->unlogin = "N";
        $this->timestamp = 0;
    }

    public function getUnlogin(): ?string
    {
        return HtmlDecode($this->unlogin);
    }

    public function setUnlogin(?string $value): static
    {
        $this->unlogin = RemoveXss($value);
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

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $value): static
    {
        $this->timestamp = $value;
        return $this;
    }

    public function getIp(): string
    {
        return HtmlDecode($this->ip);
    }

    public function setIp(string $value): static
    {
        $this->ip = RemoveXss($value);
        return $this;
    }

    public function getFile(): string
    {
        return HtmlDecode($this->file);
    }

    public function setFile(string $value): static
    {
        $this->file = RemoveXss($value);
        return $this;
    }

    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    public function setUpdated(?DateTime $value): static
    {
        $this->updated = $value;
        return $this;
    }

    public function getLastActivity(): ?DateTime
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?DateTime $value): static
    {
        $this->lastActivity = $value;
        return $this;
    }
}
