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
 * Entity class for "sco_expediente_old" table
 */
#[Entity]
#[Table(name: "sco_expediente_old")]
class ScoExpedienteOld extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nexpediente;

    #[Column(name: "tipo_contratacion", type: "string")]
    private string $tipoContratacion;

    #[Column(type: "integer")]
    private int $seguro;

    #[Column(name: "nacionalidad_contacto", type: "string")]
    private string $nacionalidadContacto;

    #[Column(name: "cedula_contacto", type: "string")]
    private string $cedulaContacto;

    #[Column(name: "nombre_contacto", type: "string")]
    private string $nombreContacto;

    #[Column(name: "apellidos_contacto", type: "string")]
    private string $apellidosContacto;

    #[Column(name: "parentesco_contacto", type: "string")]
    private string $parentescoContacto;

    #[Column(name: "telefono_contacto1", type: "string")]
    private string $telefonoContacto1;

    #[Column(name: "telefono_contacto2", type: "string", nullable: true)]
    private ?string $telefonoContacto2;

    #[Column(name: "nacionalidad_fallecido", type: "string", nullable: true)]
    private ?string $nacionalidadFallecido;

    #[Column(name: "cedula_fallecido", type: "string", unique: true, nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $sexo;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellidos_fallecido", type: "string", nullable: true)]
    private ?string $apellidosFallecido;

    #[Column(name: "fecha_nacimiento", type: "date", nullable: true)]
    private ?DateTime $fechaNacimiento;

    #[Column(name: "edad_fallecido", type: "smallint", nullable: true)]
    private ?int $edadFallecido;

    #[Column(name: "estado_civil", type: "string", nullable: true)]
    private ?string $estadoCivil;

    #[Column(name: "lugar_nacimiento_fallecido", type: "string", nullable: true)]
    private ?string $lugarNacimientoFallecido;

    #[Column(name: "lugar_ocurrencia", type: "string", nullable: true)]
    private ?string $lugarOcurrencia;

    #[Column(name: "direccion_ocurrencia", type: "string", nullable: true)]
    private ?string $direccionOcurrencia;

    #[Column(name: "fecha_ocurrencia", type: "date", nullable: true)]
    private ?DateTime $fechaOcurrencia;

    #[Column(name: "hora_ocurrencia", type: "time", nullable: true)]
    private ?DateTime $horaOcurrencia;

    #[Column(name: "causa_ocurrencia", type: "string", nullable: true)]
    private ?string $causaOcurrencia;

    #[Column(name: "causa_otro", type: "string", nullable: true)]
    private ?string $causaOtro;

    #[Column(name: "descripcion_ocurrencia", type: "text", nullable: true)]
    private ?string $descripcionOcurrencia;

    #[Column(type: "string", nullable: true)]
    private ?string $calidad;

    #[Column(type: "decimal", nullable: true)]
    private ?string $costos;

    #[Column(type: "decimal", nullable: true)]
    private ?string $venta;

    #[Column(name: "user_registra", type: "string", nullable: true)]
    private ?string $userRegistra;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "user_cierra", type: "string", nullable: true)]
    private ?string $userCierra;

    #[Column(name: "fecha_cierre", type: "datetime", nullable: true)]
    private ?DateTime $fechaCierre;

    #[Column(type: "integer", nullable: true)]
    private ?int $estatus;

    #[Column(type: "string", nullable: true)]
    private ?string $factura;

    #[Column(type: "string", nullable: true)]
    private ?string $permiso;

    #[Column(name: "unir_con_expediente", type: "bigint", nullable: true)]
    private ?string $unirConExpediente;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $religion;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Column(type: "string", nullable: true)]
    private ?string $servicio;

    #[Column(type: "integer", nullable: true)]
    private ?int $funeraria;

    #[Column(name: "marca_pasos", type: "string", nullable: true)]
    private ?string $marcaPasos;

    #[Column(name: "autoriza_cremar", type: "string", nullable: true)]
    private ?string $autorizaCremar;

    #[Column(name: "username_autoriza", type: "string", nullable: true)]
    private ?string $usernameAutoriza;

    #[Column(name: "fecha_autoriza", type: "datetime", nullable: true)]
    private ?DateTime $fechaAutoriza;

    #[Column(type: "string", nullable: true)]
    private ?string $peso;

    #[Column(name: "contrato_parcela", type: "string", nullable: true)]
    private ?string $contratoParcela;

    #[Column(name: "email_calidad", type: "string", nullable: true)]
    private ?string $emailCalidad;

    #[Column(name: "certificado_defuncion", type: "string", nullable: true)]
    private ?string $certificadoDefuncion;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    public function __construct()
    {
        $this->venta = "0.00";
        $this->marcaPasos = "N";
        $this->autorizaCremar = "N";
        $this->emailCalidad = "N";
    }

    public function getNexpediente(): string
    {
        return $this->nexpediente;
    }

    public function setNexpediente(string $value): static
    {
        $this->nexpediente = $value;
        return $this;
    }

    public function getTipoContratacion(): string
    {
        return HtmlDecode($this->tipoContratacion);
    }

    public function setTipoContratacion(string $value): static
    {
        $this->tipoContratacion = RemoveXss($value);
        return $this;
    }

    public function getSeguro(): int
    {
        return $this->seguro;
    }

    public function setSeguro(int $value): static
    {
        $this->seguro = $value;
        return $this;
    }

    public function getNacionalidadContacto(): string
    {
        return HtmlDecode($this->nacionalidadContacto);
    }

    public function setNacionalidadContacto(string $value): static
    {
        $this->nacionalidadContacto = RemoveXss($value);
        return $this;
    }

    public function getCedulaContacto(): string
    {
        return HtmlDecode($this->cedulaContacto);
    }

    public function setCedulaContacto(string $value): static
    {
        $this->cedulaContacto = RemoveXss($value);
        return $this;
    }

    public function getNombreContacto(): string
    {
        return HtmlDecode($this->nombreContacto);
    }

    public function setNombreContacto(string $value): static
    {
        $this->nombreContacto = RemoveXss($value);
        return $this;
    }

    public function getApellidosContacto(): string
    {
        return HtmlDecode($this->apellidosContacto);
    }

    public function setApellidosContacto(string $value): static
    {
        $this->apellidosContacto = RemoveXss($value);
        return $this;
    }

    public function getParentescoContacto(): string
    {
        return HtmlDecode($this->parentescoContacto);
    }

    public function setParentescoContacto(string $value): static
    {
        $this->parentescoContacto = RemoveXss($value);
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

    public function getNacionalidadFallecido(): ?string
    {
        return HtmlDecode($this->nacionalidadFallecido);
    }

    public function setNacionalidadFallecido(?string $value): static
    {
        $this->nacionalidadFallecido = RemoveXss($value);
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

    public function getSexo(): ?string
    {
        return HtmlDecode($this->sexo);
    }

    public function setSexo(?string $value): static
    {
        $this->sexo = RemoveXss($value);
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

    public function getEstadoCivil(): ?string
    {
        return HtmlDecode($this->estadoCivil);
    }

    public function setEstadoCivil(?string $value): static
    {
        $this->estadoCivil = RemoveXss($value);
        return $this;
    }

    public function getLugarNacimientoFallecido(): ?string
    {
        return HtmlDecode($this->lugarNacimientoFallecido);
    }

    public function setLugarNacimientoFallecido(?string $value): static
    {
        $this->lugarNacimientoFallecido = RemoveXss($value);
        return $this;
    }

    public function getLugarOcurrencia(): ?string
    {
        return HtmlDecode($this->lugarOcurrencia);
    }

    public function setLugarOcurrencia(?string $value): static
    {
        $this->lugarOcurrencia = RemoveXss($value);
        return $this;
    }

    public function getDireccionOcurrencia(): ?string
    {
        return HtmlDecode($this->direccionOcurrencia);
    }

    public function setDireccionOcurrencia(?string $value): static
    {
        $this->direccionOcurrencia = RemoveXss($value);
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

    public function getHoraOcurrencia(): ?DateTime
    {
        return $this->horaOcurrencia;
    }

    public function setHoraOcurrencia(?DateTime $value): static
    {
        $this->horaOcurrencia = $value;
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

    public function getDescripcionOcurrencia(): ?string
    {
        return HtmlDecode($this->descripcionOcurrencia);
    }

    public function setDescripcionOcurrencia(?string $value): static
    {
        $this->descripcionOcurrencia = RemoveXss($value);
        return $this;
    }

    public function getCalidad(): ?string
    {
        return HtmlDecode($this->calidad);
    }

    public function setCalidad(?string $value): static
    {
        $this->calidad = RemoveXss($value);
        return $this;
    }

    public function getCostos(): ?string
    {
        return $this->costos;
    }

    public function setCostos(?string $value): static
    {
        $this->costos = $value;
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

    public function getUserCierra(): ?string
    {
        return HtmlDecode($this->userCierra);
    }

    public function setUserCierra(?string $value): static
    {
        $this->userCierra = RemoveXss($value);
        return $this;
    }

    public function getFechaCierre(): ?DateTime
    {
        return $this->fechaCierre;
    }

    public function setFechaCierre(?DateTime $value): static
    {
        $this->fechaCierre = $value;
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

    public function getFactura(): ?string
    {
        return HtmlDecode($this->factura);
    }

    public function setFactura(?string $value): static
    {
        $this->factura = RemoveXss($value);
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

    public function getUnirConExpediente(): ?string
    {
        return $this->unirConExpediente;
    }

    public function setUnirConExpediente(?string $value): static
    {
        $this->unirConExpediente = $value;
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

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getReligion(): ?string
    {
        return HtmlDecode($this->religion);
    }

    public function setReligion(?string $value): static
    {
        $this->religion = RemoveXss($value);
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

    public function getServicio(): ?string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(?string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }

    public function getFuneraria(): ?int
    {
        return $this->funeraria;
    }

    public function setFuneraria(?int $value): static
    {
        $this->funeraria = $value;
        return $this;
    }

    public function getMarcaPasos(): ?string
    {
        return $this->marcaPasos;
    }

    public function setMarcaPasos(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'marca_pasos' value");
        }
        $this->marcaPasos = $value;
        return $this;
    }

    public function getAutorizaCremar(): ?string
    {
        return $this->autorizaCremar;
    }

    public function setAutorizaCremar(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'autoriza_cremar' value");
        }
        $this->autorizaCremar = $value;
        return $this;
    }

    public function getUsernameAutoriza(): ?string
    {
        return HtmlDecode($this->usernameAutoriza);
    }

    public function setUsernameAutoriza(?string $value): static
    {
        $this->usernameAutoriza = RemoveXss($value);
        return $this;
    }

    public function getFechaAutoriza(): ?DateTime
    {
        return $this->fechaAutoriza;
    }

    public function setFechaAutoriza(?DateTime $value): static
    {
        $this->fechaAutoriza = $value;
        return $this;
    }

    public function getPeso(): ?string
    {
        return HtmlDecode($this->peso);
    }

    public function setPeso(?string $value): static
    {
        $this->peso = RemoveXss($value);
        return $this;
    }

    public function getContratoParcela(): ?string
    {
        return HtmlDecode($this->contratoParcela);
    }

    public function setContratoParcela(?string $value): static
    {
        $this->contratoParcela = RemoveXss($value);
        return $this;
    }

    public function getEmailCalidad(): ?string
    {
        return $this->emailCalidad;
    }

    public function setEmailCalidad(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'email_calidad' value");
        }
        $this->emailCalidad = $value;
        return $this;
    }

    public function getCertificadoDefuncion(): ?string
    {
        return HtmlDecode($this->certificadoDefuncion);
    }

    public function setCertificadoDefuncion(?string $value): static
    {
        $this->certificadoDefuncion = RemoveXss($value);
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
