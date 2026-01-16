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
 * Entity class for "view_expediente_servicio" table
 */
#[Entity]
#[Table(name: "view_expediente_servicio")]
class ViewExpedienteServicio extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente", type: "bigint", nullable: true)]
    private ?string $nexpediente;

    #[Column(type: "string", nullable: true)]
    private ?string $seguro;

    #[Column(name: "nombre_contacto", type: "string", nullable: true)]
    private ?string $nombreContacto;

    #[Column(name: "telefono_contacto1", type: "string", nullable: true)]
    private ?string $telefonoContacto1;

    #[Column(name: "telefono_contacto2", type: "string", nullable: true)]
    private ?string $telefonoContacto2;

    #[Column(name: "cedula_fallecido", type: "string", nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellidos_fallecido", type: "string", nullable: true)]
    private ?string $apellidosFallecido;

    #[Column(name: "fecha_nacimiento", type: "date", nullable: true)]
    private ?DateTime $fechaNacimiento;

    #[Column(name: "edad_fallecido", type: "smallint", nullable: true)]
    private ?int $edadFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $sexo;

    #[Column(name: "fecha_ocurrencia", type: "date", nullable: true)]
    private ?DateTime $fechaOcurrencia;

    #[Column(name: "causa_ocurrencia", type: "string", nullable: true)]
    private ?string $causaOcurrencia;

    #[Column(name: "causa_otro", type: "string", nullable: true)]
    private ?string $causaOtro;

    #[Column(type: "string", nullable: true)]
    private ?string $permiso;

    #[Column(type: "text", nullable: true)]
    private ?string $capilla;

    #[Column(type: "text", nullable: true)]
    private ?string $horas;

    #[Column(type: "string", nullable: true)]
    private ?string $ataud;

    #[Column(name: "arreglo_floral", type: "decimal", nullable: true)]
    private ?string $arregloFloral;

    #[Column(name: "oficio_religioso", type: "decimal", nullable: true)]
    private ?string $oficioReligioso;

    #[Column(name: "ofrenda_voz", type: "decimal", nullable: true)]
    private ?string $ofrendaVoz;

    #[Column(name: "fecha_inicio", type: "string", nullable: true)]
    private ?string $fechaInicio;

    #[Column(name: "hora_inicio", type: "time", nullable: true)]
    private ?DateTime $horaInicio;

    #[Column(name: "fecha_fin", type: "string", nullable: true)]
    private ?string $fechaFin;

    #[Column(name: "hora_fin", type: "time", nullable: true)]
    private ?DateTime $horaFin;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(name: "fecha_serv", type: "string", nullable: true)]
    private ?string $fechaServ;

    #[Column(name: "hora_serv", type: "time", nullable: true)]
    private ?DateTime $horaServ;

    #[Column(name: "espera_cenizas", type: "string", nullable: true)]
    private ?string $esperaCenizas;

    #[Column(name: "hora_fin_capilla", type: "time", nullable: true)]
    private ?DateTime $horaFinCapilla;

    #[Column(name: "hora_fin_servicio", type: "time", nullable: true)]
    private ?DateTime $horaFinServicio;

    #[Column(type: "integer", nullable: true)]
    private ?int $estatus;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(type: "string", nullable: true)]
    private ?string $factura;

    #[Column(type: "decimal", nullable: true)]
    private ?string $venta;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "text", nullable: true)]
    private ?string $sede;

    #[Column(type: "bigint")]
    private string $funeraria;

    #[Column(name: "cod_servicio", type: "string", nullable: true)]
    private ?string $codServicio;

    #[Column(type: "string", nullable: true)]
    private ?string $coordinador;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    public function __construct()
    {
        $this->nexpediente = "0";
        $this->esperaCenizas = "N";
        $this->venta = "0.00";
        $this->funeraria = "0";
    }

    public function getNexpediente(): ?string
    {
        return $this->nexpediente;
    }

    public function setNexpediente(?string $value): static
    {
        $this->nexpediente = $value;
        return $this;
    }

    public function getSeguro(): ?string
    {
        return HtmlDecode($this->seguro);
    }

    public function setSeguro(?string $value): static
    {
        $this->seguro = RemoveXss($value);
        return $this;
    }

    public function getNombreContacto(): ?string
    {
        return HtmlDecode($this->nombreContacto);
    }

    public function setNombreContacto(?string $value): static
    {
        $this->nombreContacto = RemoveXss($value);
        return $this;
    }

    public function getTelefonoContacto1(): ?string
    {
        return HtmlDecode($this->telefonoContacto1);
    }

    public function setTelefonoContacto1(?string $value): static
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

    public function getCedulaFallecido(): ?string
    {
        return HtmlDecode($this->cedulaFallecido);
    }

    public function setCedulaFallecido(?string $value): static
    {
        $this->cedulaFallecido = RemoveXss($value);
        return $this;
    }

    public function getNombreFallecido(): ?string
    {
        return HtmlDecode($this->nombreFallecido);
    }

    public function setNombreFallecido(?string $value): static
    {
        $this->nombreFallecido = RemoveXss($value);
        return $this;
    }

    public function getApellidosFallecido(): ?string
    {
        return HtmlDecode($this->apellidosFallecido);
    }

    public function setApellidosFallecido(?string $value): static
    {
        $this->apellidosFallecido = RemoveXss($value);
        return $this;
    }

    public function getFechaNacimiento(): ?DateTime
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?DateTime $value): static
    {
        $this->fechaNacimiento = $value;
        return $this;
    }

    public function getEdadFallecido(): ?int
    {
        return $this->edadFallecido;
    }

    public function setEdadFallecido(?int $value): static
    {
        $this->edadFallecido = $value;
        return $this;
    }

    public function getSexo(): ?string
    {
        return HtmlDecode($this->sexo);
    }

    public function setSexo(?string $value): static
    {
        $this->sexo = RemoveXss($value);
        return $this;
    }

    public function getFechaOcurrencia(): ?DateTime
    {
        return $this->fechaOcurrencia;
    }

    public function setFechaOcurrencia(?DateTime $value): static
    {
        $this->fechaOcurrencia = $value;
        return $this;
    }

    public function getCausaOcurrencia(): ?string
    {
        return HtmlDecode($this->causaOcurrencia);
    }

    public function setCausaOcurrencia(?string $value): static
    {
        $this->causaOcurrencia = RemoveXss($value);
        return $this;
    }

    public function getCausaOtro(): ?string
    {
        return HtmlDecode($this->causaOtro);
    }

    public function setCausaOtro(?string $value): static
    {
        $this->causaOtro = RemoveXss($value);
        return $this;
    }

    public function getPermiso(): ?string
    {
        return HtmlDecode($this->permiso);
    }

    public function setPermiso(?string $value): static
    {
        $this->permiso = RemoveXss($value);
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

    public function getHoras(): ?string
    {
        return HtmlDecode($this->horas);
    }

    public function setHoras(?string $value): static
    {
        $this->horas = RemoveXss($value);
        return $this;
    }

    public function getAtaud(): ?string
    {
        return HtmlDecode($this->ataud);
    }

    public function setAtaud(?string $value): static
    {
        $this->ataud = RemoveXss($value);
        return $this;
    }

    public function getArregloFloral(): ?string
    {
        return $this->arregloFloral;
    }

    public function setArregloFloral(?string $value): static
    {
        $this->arregloFloral = $value;
        return $this;
    }

    public function getOficioReligioso(): ?string
    {
        return $this->oficioReligioso;
    }

    public function setOficioReligioso(?string $value): static
    {
        $this->oficioReligioso = $value;
        return $this;
    }

    public function getOfrendaVoz(): ?string
    {
        return $this->ofrendaVoz;
    }

    public function setOfrendaVoz(?string $value): static
    {
        $this->ofrendaVoz = $value;
        return $this;
    }

    public function getFechaInicio(): ?string
    {
        return HtmlDecode($this->fechaInicio);
    }

    public function setFechaInicio(?string $value): static
    {
        $this->fechaInicio = RemoveXss($value);
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

    public function getFechaFin(): ?string
    {
        return HtmlDecode($this->fechaFin);
    }

    public function setFechaFin(?string $value): static
    {
        $this->fechaFin = RemoveXss($value);
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

    public function getServicio(): ?string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(?string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }

    public function getFechaServ(): ?string
    {
        return HtmlDecode($this->fechaServ);
    }

    public function setFechaServ(?string $value): static
    {
        $this->fechaServ = RemoveXss($value);
        return $this;
    }

    public function getHoraServ(): ?DateTime
    {
        return $this->horaServ;
    }

    public function setHoraServ(?DateTime $value): static
    {
        $this->horaServ = $value;
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

    public function getHoraFinCapilla(): ?DateTime
    {
        return $this->horaFinCapilla;
    }

    public function setHoraFinCapilla(?DateTime $value): static
    {
        $this->horaFinCapilla = $value;
        return $this;
    }

    public function getHoraFinServicio(): ?DateTime
    {
        return $this->horaFinServicio;
    }

    public function setHoraFinServicio(?DateTime $value): static
    {
        $this->horaFinServicio = $value;
        return $this;
    }

    public function getEstatus(): ?int
    {
        return $this->estatus;
    }

    public function setEstatus(?int $value): static
    {
        $this->estatus = $value;
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

    public function getFactura(): ?string
    {
        return HtmlDecode($this->factura);
    }

    public function setFactura(?string $value): static
    {
        $this->factura = RemoveXss($value);
        return $this;
    }

    public function getVenta(): ?string
    {
        return $this->venta;
    }

    public function setVenta(?string $value): static
    {
        $this->venta = $value;
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

    public function getSede(): ?string
    {
        return HtmlDecode($this->sede);
    }

    public function setSede(?string $value): static
    {
        $this->sede = RemoveXss($value);
        return $this;
    }

    public function getFuneraria(): string
    {
        return $this->funeraria;
    }

    public function setFuneraria(string $value): static
    {
        $this->funeraria = $value;
        return $this;
    }

    public function getCodServicio(): ?string
    {
        return HtmlDecode($this->codServicio);
    }

    public function setCodServicio(?string $value): static
    {
        $this->codServicio = RemoveXss($value);
        return $this;
    }

    public function getCoordinador(): ?string
    {
        return HtmlDecode($this->coordinador);
    }

    public function setCoordinador(?string $value): static
    {
        $this->coordinador = RemoveXss($value);
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
}
