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
 * Entity class for "view_orden_prov" table
 */
#[Entity]
#[Table(name: "view_orden_prov")]
class ViewOrdenProv extends AbstractEntity
{
    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(type: "integer")]
    private int $proveedor;

    #[Column(type: "string", nullable: true)]
    private ?string $difunto;

    #[Column(type: "string")]
    private string $tipo;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Column(type: "text", nullable: true)]
    private ?string $capilla;

    #[Column(name: "fecha_inicio", type: "datetime", nullable: true)]
    private ?DateTime $fechaInicio;

    #[Column(name: "hora_inicio", type: "time", nullable: true)]
    private ?DateTime $horaInicio;

    #[Column(name: "fecha_fin", type: "datetime", nullable: true)]
    private ?DateTime $fechaFin;

    #[Column(name: "hora_fin", type: "time", nullable: true)]
    private ?DateTime $horaFin;

    #[Column(name: "horas_velacion", type: "string")]
    private string $horasVelacion;

    #[Column(name: "llevar_a", type: "string")]
    private string $llevarA;

    #[Column(type: "text", nullable: true)]
    private ?string $ajunto;

    #[Column(type: "integer")]
    private int $paso;

    #[Column(name: "servicio_atendido", type: "string", nullable: true)]
    private ?string $servicioAtendido;

    public function __construct()
    {
        $this->proveedor = 0;
        $this->paso = 0;
        $this->servicioAtendido = "N";
    }

    public function getExpediente(): string
    {
        return $this->expediente;
    }

    public function setExpediente(string $value): static
    {
        $this->expediente = $value;
        return $this;
    }

    public function getProveedor(): int
    {
        return $this->proveedor;
    }

    public function setProveedor(int $value): static
    {
        $this->proveedor = $value;
        return $this;
    }

    public function getDifunto(): ?string
    {
        return HtmlDecode($this->difunto);
    }

    public function setDifunto(?string $value): static
    {
        $this->difunto = RemoveXss($value);
        return $this;
    }

    public function getTipo(): string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }

    public function getServicioTipo(): ?string
    {
        return HtmlDecode($this->servicioTipo);
    }

    public function setServicioTipo(?string $value): static
    {
        $this->servicioTipo = RemoveXss($value);
        return $this;
    }

    public function getCapilla(): ?string
    {
        return HtmlDecode($this->capilla);
    }

    public function setCapilla(?string $value): static
    {
        $this->capilla = RemoveXss($value);
        return $this;
    }

    public function getFechaInicio(): ?DateTime
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(?DateTime $value): static
    {
        $this->fechaInicio = $value;
        return $this;
    }

    public function getHoraInicio(): ?DateTime
    {
        return $this->horaInicio;
    }

    public function setHoraInicio(?DateTime $value): static
    {
        $this->horaInicio = $value;
        return $this;
    }

    public function getFechaFin(): ?DateTime
    {
        return $this->fechaFin;
    }

    public function setFechaFin(?DateTime $value): static
    {
        $this->fechaFin = $value;
        return $this;
    }

    public function getHoraFin(): ?DateTime
    {
        return $this->horaFin;
    }

    public function setHoraFin(?DateTime $value): static
    {
        $this->horaFin = $value;
        return $this;
    }

    public function getHorasVelacion(): string
    {
        return HtmlDecode($this->horasVelacion);
    }

    public function setHorasVelacion(string $value): static
    {
        $this->horasVelacion = RemoveXss($value);
        return $this;
    }

    public function getLlevarA(): string
    {
        return HtmlDecode($this->llevarA);
    }

    public function setLlevarA(string $value): static
    {
        $this->llevarA = RemoveXss($value);
        return $this;
    }

    public function getAjunto(): ?string
    {
        return HtmlDecode($this->ajunto);
    }

    public function setAjunto(?string $value): static
    {
        $this->ajunto = RemoveXss($value);
        return $this;
    }

    public function getPaso(): int
    {
        return $this->paso;
    }

    public function setPaso(int $value): static
    {
        $this->paso = $value;
        return $this;
    }

    public function getServicioAtendido(): ?string
    {
        return HtmlDecode($this->servicioAtendido);
    }

    public function setServicioAtendido(?string $value): static
    {
        $this->servicioAtendido = RemoveXss($value);
        return $this;
    }
}
