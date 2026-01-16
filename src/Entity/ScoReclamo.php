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
 * Entity class for "sco_reclamo" table
 */
#[Entity]
#[Table(name: "sco_reclamo")]
class ScoReclamo extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nreclamo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nreclamo;

    #[Column(type: "string", nullable: true)]
    private ?string $solicitante;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(name: "ci_difunto", type: "string", nullable: true)]
    private ?string $ciDifunto;

    #[Column(name: "nombre_difunto", type: "string", nullable: true)]
    private ?string $nombreDifunto;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $comentario;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $registro;

    #[Column(type: "string", nullable: true)]
    private ?string $registra;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $modificacion;

    #[Column(type: "string", nullable: true)]
    private ?string $modifica;

    #[Column(name: "mensaje_cliente", type: "bigint", nullable: true)]
    private ?string $mensajeCliente;

    #[Column(type: "string", nullable: true)]
    private ?string $seccion;

    #[Column(type: "string", nullable: true)]
    private ?string $modulo;

    #[Column(name: "sub_seccion", type: "string", nullable: true)]
    private ?string $subSeccion;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    #[Column(type: "string", nullable: true)]
    private ?string $boveda;

    #[Column(type: "string", nullable: true)]
    private ?string $parentesco;

    public function __construct()
    {
        $this->mensajeCliente = "0";
    }

    public function getNreclamo(): int
    {
        return $this->nreclamo;
    }

    public function setNreclamo(int $value): static
    {
        $this->nreclamo = $value;
        return $this;
    }

    public function getSolicitante(): ?string
    {
        return HtmlDecode($this->solicitante);
    }

    public function setSolicitante(?string $value): static
    {
        $this->solicitante = RemoveXss($value);
        return $this;
    }

    public function getTelefono1(): ?string
    {
        return HtmlDecode($this->telefono1);
    }

    public function setTelefono1(?string $value): static
    {
        $this->telefono1 = RemoveXss($value);
        return $this;
    }

    public function getTelefono2(): ?string
    {
        return HtmlDecode($this->telefono2);
    }

    public function setTelefono2(?string $value): static
    {
        $this->telefono2 = RemoveXss($value);
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

    public function getCiDifunto(): ?string
    {
        return HtmlDecode($this->ciDifunto);
    }

    public function setCiDifunto(?string $value): static
    {
        $this->ciDifunto = RemoveXss($value);
        return $this;
    }

    public function getNombreDifunto(): ?string
    {
        return HtmlDecode($this->nombreDifunto);
    }

    public function setNombreDifunto(?string $value): static
    {
        $this->nombreDifunto = RemoveXss($value);
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

    public function getComentario(): ?string
    {
        return HtmlDecode($this->comentario);
    }

    public function setComentario(?string $value): static
    {
        $this->comentario = RemoveXss($value);
        return $this;
    }

    public function getEstatus(): ?string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(?string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }

    public function getRegistro(): ?DateTime
    {
        return $this->registro;
    }

    public function setRegistro(?DateTime $value): static
    {
        $this->registro = $value;
        return $this;
    }

    public function getRegistra(): ?string
    {
        return HtmlDecode($this->registra);
    }

    public function setRegistra(?string $value): static
    {
        $this->registra = RemoveXss($value);
        return $this;
    }

    public function getModificacion(): ?DateTime
    {
        return $this->modificacion;
    }

    public function setModificacion(?DateTime $value): static
    {
        $this->modificacion = $value;
        return $this;
    }

    public function getModifica(): ?string
    {
        return HtmlDecode($this->modifica);
    }

    public function setModifica(?string $value): static
    {
        $this->modifica = RemoveXss($value);
        return $this;
    }

    public function getMensajeCliente(): ?string
    {
        return $this->mensajeCliente;
    }

    public function setMensajeCliente(?string $value): static
    {
        $this->mensajeCliente = $value;
        return $this;
    }

    public function getSeccion(): ?string
    {
        return HtmlDecode($this->seccion);
    }

    public function setSeccion(?string $value): static
    {
        $this->seccion = RemoveXss($value);
        return $this;
    }

    public function getModulo(): ?string
    {
        return HtmlDecode($this->modulo);
    }

    public function setModulo(?string $value): static
    {
        $this->modulo = RemoveXss($value);
        return $this;
    }

    public function getSubSeccion(): ?string
    {
        return HtmlDecode($this->subSeccion);
    }

    public function setSubSeccion(?string $value): static
    {
        $this->subSeccion = RemoveXss($value);
        return $this;
    }

    public function getParcela(): ?string
    {
        return HtmlDecode($this->parcela);
    }

    public function setParcela(?string $value): static
    {
        $this->parcela = RemoveXss($value);
        return $this;
    }

    public function getBoveda(): ?string
    {
        return HtmlDecode($this->boveda);
    }

    public function setBoveda(?string $value): static
    {
        $this->boveda = RemoveXss($value);
        return $this;
    }

    public function getParentesco(): ?string
    {
        return HtmlDecode($this->parentesco);
    }

    public function setParentesco(?string $value): static
    {
        $this->parentesco = RemoveXss($value);
        return $this;
    }
}
