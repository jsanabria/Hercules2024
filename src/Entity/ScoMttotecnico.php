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
 * Entity class for "sco_mttotecnico" table
 */
#[Entity]
#[Table(name: "sco_mttotecnico")]
class ScoMttotecnico extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmttotecnico", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nmttotecnico;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "user_solicita", type: "string", nullable: true)]
    private ?string $userSolicita;

    #[Column(name: "tipo_solicitud", type: "string", nullable: true)]
    private ?string $tipoSolicitud;

    #[Column(name: "unidad_solicitante", type: "string", nullable: true)]
    private ?string $unidadSolicitante;

    #[Column(name: "area_falla", type: "string", nullable: true)]
    private ?string $areaFalla;

    #[Column(type: "string", nullable: true)]
    private ?string $comentario;

    #[Column(type: "string", nullable: true)]
    private ?string $prioridad;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(name: "falla_atendida_por", type: "string", nullable: true)]
    private ?string $fallaAtendidaPor;

    #[Column(type: "string", nullable: true)]
    private ?string $diagnostico;

    #[Column(type: "string", nullable: true)]
    private ?string $solucion;

    #[Column(name: "user_diagnostico", type: "string", nullable: true)]
    private ?string $userDiagnostico;

    #[Column(name: "requiere_materiales", type: "string", nullable: true)]
    private ?string $requiereMateriales;

    #[Column(name: "fecha_solucion", type: "datetime", nullable: true)]
    private ?DateTime $fechaSolucion;

    #[Column(type: "string", nullable: true)]
    private ?string $materiales;

    public function __construct()
    {
        $this->requiereMateriales = "N";
    }

    public function getNmttotecnico(): int
    {
        return $this->nmttotecnico;
    }

    public function setNmttotecnico(int $value): static
    {
        $this->nmttotecnico = $value;
        return $this;
    }

    public function getFechaRegistro(): ?DateTime
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?DateTime $value): static
    {
        $this->fechaRegistro = $value;
        return $this;
    }

    public function getUserSolicita(): ?string
    {
        return HtmlDecode($this->userSolicita);
    }

    public function setUserSolicita(?string $value): static
    {
        $this->userSolicita = RemoveXss($value);
        return $this;
    }

    public function getTipoSolicitud(): ?string
    {
        return HtmlDecode($this->tipoSolicitud);
    }

    public function setTipoSolicitud(?string $value): static
    {
        $this->tipoSolicitud = RemoveXss($value);
        return $this;
    }

    public function getUnidadSolicitante(): ?string
    {
        return HtmlDecode($this->unidadSolicitante);
    }

    public function setUnidadSolicitante(?string $value): static
    {
        $this->unidadSolicitante = RemoveXss($value);
        return $this;
    }

    public function getAreaFalla(): ?string
    {
        return HtmlDecode($this->areaFalla);
    }

    public function setAreaFalla(?string $value): static
    {
        $this->areaFalla = RemoveXss($value);
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

    public function getPrioridad(): ?string
    {
        return HtmlDecode($this->prioridad);
    }

    public function setPrioridad(?string $value): static
    {
        $this->prioridad = RemoveXss($value);
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

    public function getFallaAtendidaPor(): ?string
    {
        return HtmlDecode($this->fallaAtendidaPor);
    }

    public function setFallaAtendidaPor(?string $value): static
    {
        $this->fallaAtendidaPor = RemoveXss($value);
        return $this;
    }

    public function getDiagnostico(): ?string
    {
        return HtmlDecode($this->diagnostico);
    }

    public function setDiagnostico(?string $value): static
    {
        $this->diagnostico = RemoveXss($value);
        return $this;
    }

    public function getSolucion(): ?string
    {
        return HtmlDecode($this->solucion);
    }

    public function setSolucion(?string $value): static
    {
        $this->solucion = RemoveXss($value);
        return $this;
    }

    public function getUserDiagnostico(): ?string
    {
        return HtmlDecode($this->userDiagnostico);
    }

    public function setUserDiagnostico(?string $value): static
    {
        $this->userDiagnostico = RemoveXss($value);
        return $this;
    }

    public function getRequiereMateriales(): ?string
    {
        return $this->requiereMateriales;
    }

    public function setRequiereMateriales(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'requiere_materiales' value");
        }
        $this->requiereMateriales = $value;
        return $this;
    }

    public function getFechaSolucion(): ?DateTime
    {
        return $this->fechaSolucion;
    }

    public function setFechaSolucion(?DateTime $value): static
    {
        $this->fechaSolucion = $value;
        return $this;
    }

    public function getMateriales(): ?string
    {
        return HtmlDecode($this->materiales);
    }

    public function setMateriales(?string $value): static
    {
        $this->materiales = RemoveXss($value);
        return $this;
    }
}
