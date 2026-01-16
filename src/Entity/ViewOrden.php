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
 * Entity class for "view_orden" table
 */
#[Entity]
#[Table(name: "view_orden")]
class ViewOrden extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden", type: "bigint")]
    #[GeneratedValue]
    private string $norden;

    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(type: "string", nullable: true)]
    private ?string $difunto;

    #[Column(name: "servicio_tipo", type: "string")]
    private string $servicioTipo;

    #[Column(type: "string")]
    private string $servicio;

    #[Column(type: "integer")]
    private int $paso;

    #[Column(type: "integer")]
    private int $proveedor;

    #[Column(name: "responsable_servicio", type: "string", nullable: true)]
    private ?string $responsableServicio;

    #[Column(name: "fecha_inicio", type: "datetime", nullable: true)]
    private ?DateTime $fechaInicio;

    #[Column(name: "hora_inicio", type: "time", nullable: true)]
    private ?DateTime $horaInicio;

    #[Column(type: "bigint")]
    private string $horas;

    #[Column(name: "fecha_fin", type: "datetime", nullable: true)]
    private ?DateTime $fechaFin;

    #[Column(name: "hora_fin", type: "time", nullable: true)]
    private ?DateTime $horaFin;

    #[Column(type: "integer", nullable: true)]
    private ?int $capilla;

    #[Column(type: "integer")]
    private int $cantidad;

    #[Column(type: "float")]
    private float $costo;

    #[Column(type: "float")]
    private float $total;

    #[Column(type: "text", nullable: true)]
    private ?string $nota;

    #[Column(name: "referencia_ubicacion", type: "string", nullable: true)]
    private ?string $referenciaUbicacion;

    #[Column(type: "string", nullable: true)]
    private ?string $anulada;

    #[Column(name: "user_registra", type: "string", nullable: true)]
    private ?string $userRegistra;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "media_hora", type: "string", nullable: true)]
    private ?string $mediaHora;

    #[Column(name: "espera_cenizas", type: "string", nullable: true)]
    private ?string $esperaCenizas;

    #[Column(type: "bigint", nullable: true)]
    private ?string $adjunto;

    #[Column(name: "cedula_fallecido", type: "string", nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $contacto;

    #[Column(name: "telefono_contacto1", type: "string")]
    private string $telefonoContacto1;

    #[Column(name: "telefono_contacto2", type: "string", nullable: true)]
    private ?string $telefonoContacto2;

    #[Column(name: "llevar_a", type: "string", nullable: true)]
    private ?string $llevarA;

    #[Column(name: "servicio_atendido", type: "string", nullable: true)]
    private ?string $servicioAtendido;

    public function __construct()
    {
        $this->paso = 0;
        $this->proveedor = 0;
        $this->horas = "0";
        $this->cantidad = 1;
        $this->costo = 0;
        $this->total = 0;
        $this->mediaHora = "N";
        $this->esperaCenizas = "N";
        $this->servicioAtendido = "N";
    }

    public function getNorden(): string
    {
        return $this->norden;
    }

    public function setNorden(string $value): static
    {
        $this->norden = $value;
        return $this;
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

    public function getDifunto(): ?string
    {
        return HtmlDecode($this->difunto);
    }

    public function setDifunto(?string $value): static
    {
        $this->difunto = RemoveXss($value);
        return $this;
    }

    public function getServicioTipo(): string
    {
        return HtmlDecode($this->servicioTipo);
    }

    public function setServicioTipo(string $value): static
    {
        $this->servicioTipo = RemoveXss($value);
        return $this;
    }

    public function getServicio(): string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(string $value): static
    {
        $this->servicio = RemoveXss($value);
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

    public function getProveedor(): int
    {
        return $this->proveedor;
    }

    public function setProveedor(int $value): static
    {
        $this->proveedor = $value;
        return $this;
    }

    public function getResponsableServicio(): ?string
    {
        return HtmlDecode($this->responsableServicio);
    }

    public function setResponsableServicio(?string $value): static
    {
        $this->responsableServicio = RemoveXss($value);
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

    public function getHoras(): string
    {
        return $this->horas;
    }

    public function setHoras(string $value): static
    {
        $this->horas = $value;
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

    public function getCapilla(): ?int
    {
        return $this->capilla;
    }

    public function setCapilla(?int $value): static
    {
        $this->capilla = $value;
        return $this;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $value): static
    {
        $this->cantidad = $value;
        return $this;
    }

    public function getCosto(): float
    {
        return $this->costo;
    }

    public function setCosto(float $value): static
    {
        $this->costo = $value;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $value): static
    {
        $this->total = $value;
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

    public function getReferenciaUbicacion(): ?string
    {
        return HtmlDecode($this->referenciaUbicacion);
    }

    public function setReferenciaUbicacion(?string $value): static
    {
        $this->referenciaUbicacion = RemoveXss($value);
        return $this;
    }

    public function getAnulada(): ?string
    {
        return $this->anulada;
    }

    public function setAnulada(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'anulada' value");
        }
        $this->anulada = $value;
        return $this;
    }

    public function getUserRegistra(): ?string
    {
        return HtmlDecode($this->userRegistra);
    }

    public function setUserRegistra(?string $value): static
    {
        $this->userRegistra = RemoveXss($value);
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

    public function getMediaHora(): ?string
    {
        return HtmlDecode($this->mediaHora);
    }

    public function setMediaHora(?string $value): static
    {
        $this->mediaHora = RemoveXss($value);
        return $this;
    }

    public function getEsperaCenizas(): ?string
    {
        return HtmlDecode($this->esperaCenizas);
    }

    public function setEsperaCenizas(?string $value): static
    {
        $this->esperaCenizas = RemoveXss($value);
        return $this;
    }

    public function getAdjunto(): ?string
    {
        return $this->adjunto;
    }

    public function setAdjunto(?string $value): static
    {
        $this->adjunto = $value;
        return $this;
    }

    public function getCedulaFallecido(): ?string
    {
        return HtmlDecode($this->cedulaFallecido);
    }

    public function setCedulaFallecido(?string $value): static
    {
        $this->cedulaFallecido = RemoveXss($value);
        return $this;
    }

    public function getContacto(): ?string
    {
        return HtmlDecode($this->contacto);
    }

    public function setContacto(?string $value): static
    {
        $this->contacto = RemoveXss($value);
        return $this;
    }

    public function getTelefonoContacto1(): string
    {
        return HtmlDecode($this->telefonoContacto1);
    }

    public function setTelefonoContacto1(string $value): static
    {
        $this->telefonoContacto1 = RemoveXss($value);
        return $this;
    }

    public function getTelefonoContacto2(): ?string
    {
        return HtmlDecode($this->telefonoContacto2);
    }

    public function setTelefonoContacto2(?string $value): static
    {
        $this->telefonoContacto2 = RemoveXss($value);
        return $this;
    }

    public function getLlevarA(): ?string
    {
        return HtmlDecode($this->llevarA);
    }

    public function setLlevarA(?string $value): static
    {
        $this->llevarA = RemoveXss($value);
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
