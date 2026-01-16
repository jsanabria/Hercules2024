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
 * Entity class for "sco_email_texto" table
 */
#[Entity]
#[Table(name: "sco_email_texto")]
class ScoEmailTexto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nemail_texto", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nemailTexto;

    #[Column(type: "string", unique: true, nullable: true)]
    private ?string $script;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "text", nullable: true)]
    private ?string $texto;

    public function getNemailTexto(): int
    {
        return $this->nemailTexto;
    }

    public function setNemailTexto(int $value): static
    {
        $this->nemailTexto = $value;
        return $this;
    }

    public function getScript(): ?string
    {
        return HtmlDecode($this->script);
    }

    public function setScript(?string $value): static
    {
        $this->script = RemoveXss($value);
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(?string $value): static
    {
        $this->descripcion = RemoveXss($value);
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
}
