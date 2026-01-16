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
 * Entity class for "sco_chat_grupo" table
 */
#[Entity]
#[Table(name: "sco_chat_grupo")]
class ScoChatGrupo extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ngrupo_chat", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ngrupoChat;

    #[Column(type: "integer", nullable: true)]
    private ?int $grupo;

    #[Column(name: "ve_todo", type: "integer", nullable: true)]
    private ?int $veTodo;

    public function getNgrupoChat(): int
    {
        return $this->ngrupoChat;
    }

    public function setNgrupoChat(int $value): static
    {
        $this->ngrupoChat = $value;
        return $this;
    }

    public function getGrupo(): ?int
    {
        return $this->grupo;
    }

    public function setGrupo(?int $value): static
    {
        $this->grupo = $value;
        return $this;
    }

    public function getVeTodo(): ?int
    {
        return $this->veTodo;
    }

    public function setVeTodo(?int $value): static
    {
        $this->veTodo = $value;
        return $this;
    }
}
