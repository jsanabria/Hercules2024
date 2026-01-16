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
 * Entity class for "autogestion_ticket" table
 */
#[Entity]
#[Table(name: "autogestion_ticket")]
class AutogestionTicket extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nticket", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nticket;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Column(type: "string", nullable: true)]
    private ?string $cedula;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre;

    #[Column(type: "string", nullable: true)]
    private ?string $apellido;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(name: "cedula_fallecido", type: "string", nullable: true)]
    private ?string $cedulaFallecido;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellido_fallecido", type: "string", nullable: true)]
    private ?string $apellidoFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $ubicacion;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $recaudos;

    #[Column(type: "string", nullable: true)]
    private ?string $recaudos2;

    #[Column(name: "hora_conctactar", type: "integer", nullable: true)]
    private ?int $horaConctactar;

    #[Column(type: "string", nullable: true)]
    private ?string $contactado;

    #[Column(name: "fecha_contactado", type: "datetime", nullable: true)]
    private ?DateTime $fechaContactado;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function getNticket(): int
    {
        return $this->nticket;
    }

    public function setNticket(int $value): static
    {
        $this->nticket = $value;
        return $this;
    }

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
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

    public function getCedula(): ?string
    {
        return HtmlDecode($this->cedula);
    }

    public function setCedula(?string $value): static
    {
        $this->cedula = RemoveXss($value);
        return $this;
    }

    public function getNombre(): ?string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(?string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getApellido(): ?string
    {
        return HtmlDecode($this->apellido);
    }

    public function setApellido(?string $value): static
    {
        $this->apellido = RemoveXss($value);
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

    public function getApellidoFallecido(): ?string
    {
        return HtmlDecode($this->apellidoFallecido);
    }

    public function setApellidoFallecido(?string $value): static
    {
        $this->apellidoFallecido = RemoveXss($value);
        return $this;
    }

    public function getUbicacion(): ?string
    {
        return HtmlDecode($this->ubicacion);
    }

    public function setUbicacion(?string $value): static
    {
        $this->ubicacion = RemoveXss($value);
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

    public function getRecaudos(): ?string
    {
        return HtmlDecode($this->recaudos);
    }

    public function setRecaudos(?string $value): static
    {
        $this->recaudos = RemoveXss($value);
        return $this;
    }

    public function getRecaudos2(): ?string
    {
        return HtmlDecode($this->recaudos2);
    }

    public function setRecaudos2(?string $value): static
    {
        $this->recaudos2 = RemoveXss($value);
        return $this;
    }

    public function getHoraConctactar(): ?int
    {
        return $this->horaConctactar;
    }

    public function setHoraConctactar(?int $value): static
    {
        $this->horaConctactar = $value;
        return $this;
    }

    public function getContactado(): ?string
    {
        return $this->contactado;
    }

    public function setContactado(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'contactado' value");
        }
        $this->contactado = $value;
        return $this;
    }

    public function getFechaContactado(): ?DateTime
    {
        return $this->fechaContactado;
    }

    public function setFechaContactado(?DateTime $value): static
    {
        $this->fechaContactado = $value;
        return $this;
    }

    public function getEstatus(): ?string
    {
        return $this->estatus;
    }

    public function setEstatus(?string $value): static
    {
        if (!in_array($value, ["NUEVO", "CERRADO"])) {
            throw new \InvalidArgumentException("Invalid 'estatus' value");
        }
        $this->estatus = $value;
        return $this;
    }
}
