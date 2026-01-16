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
 * Entity class for "sco_user" table
 */
#[Entity]
#[Table(name: "sco_user")]
class ScoUser extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nuser", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nuser;

    #[Column(type: "string", nullable: true)]
    private ?string $cedula;

    #[Column(type: "string")]
    private string $nombre;

    #[Column(type: "string", unique: true)]
    private string $username;

    #[Column(type: "string")]
    private string $password;

    #[Column(type: "string")]
    private string $correo;

    #[Column(type: "string", nullable: true)]
    private ?string $direccion;

    #[Column(type: "integer")]
    private int $level;

    #[Column(type: "integer")]
    private int $activo;

    #[Column(type: "string", nullable: true)]
    private ?string $foto;

    #[Column(name: "fecha_ingreso_cia", type: "date", nullable: true)]
    private ?DateTime $fechaIngresoCia;

    #[Column(name: "fecha_egreso_cia", type: "date", nullable: true)]
    private ?DateTime $fechaEgresoCia;

    #[Column(name: "motivo_egreso", type: "string", nullable: true)]
    private ?string $motivoEgreso;

    #[Column(type: "string", nullable: true)]
    private ?string $departamento;

    #[Column(type: "string", nullable: true)]
    private ?string $cargo;

    #[Column(name: "celular_1", type: "string", nullable: true)]
    private ?string $celular1;

    #[Column(name: "celular_2", type: "string", nullable: true)]
    private ?string $celular2;

    #[Column(name: "telefono_1", type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(name: "hora_entrada", type: "time", nullable: true)]
    private ?DateTime $horaEntrada;

    #[Column(name: "hora_salida", type: "time", nullable: true)]
    private ?DateTime $horaSalida;

    #[Column(type: "integer", nullable: true)]
    private ?int $proveedor;

    #[Column(type: "integer", nullable: true)]
    private ?int $seguro;

    #[Column(name: "level_cemantick", type: "integer")]
    private int $levelCemantick;

    #[Column(type: "string")]
    private string $evaluacion;

    public function __construct()
    {
        $this->level = 0;
        $this->activo = 1;
        $this->levelCemantick = 0;
        $this->evaluacion = "N";
    }

    public function getNuser(): int
    {
        return $this->nuser;
    }

    public function setNuser(int $value): static
    {
        $this->nuser = $value;
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

    public function getNombre(): string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $value): static
    {
        $this->username = $value;
        return $this;
    }

    public function getPassword(): string
    {
        return HtmlDecode($this->password);
    }

    public function setPassword(string $value): static
    {
        $this->password = RemoveXss($value);
        return $this;
    }

    public function getCorreo(): string
    {
        return HtmlDecode($this->correo);
    }

    public function setCorreo(string $value): static
    {
        $this->correo = RemoveXss($value);
        return $this;
    }

    public function getDireccion(): ?string
    {
        return HtmlDecode($this->direccion);
    }

    public function setDireccion(?string $value): static
    {
        $this->direccion = RemoveXss($value);
        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $value): static
    {
        $this->level = $value;
        return $this;
    }

    public function getActivo(): int
    {
        return $this->activo;
    }

    public function setActivo(int $value): static
    {
        $this->activo = $value;
        return $this;
    }

    public function getFoto(): ?string
    {
        return HtmlDecode($this->foto);
    }

    public function setFoto(?string $value): static
    {
        $this->foto = RemoveXss($value);
        return $this;
    }

    public function getFechaIngresoCia(): ?DateTime
    {
        return $this->fechaIngresoCia;
    }

    public function setFechaIngresoCia(?DateTime $value): static
    {
        $this->fechaIngresoCia = $value;
        return $this;
    }

    public function getFechaEgresoCia(): ?DateTime
    {
        return $this->fechaEgresoCia;
    }

    public function setFechaEgresoCia(?DateTime $value): static
    {
        $this->fechaEgresoCia = $value;
        return $this;
    }

    public function getMotivoEgreso(): ?string
    {
        return HtmlDecode($this->motivoEgreso);
    }

    public function setMotivoEgreso(?string $value): static
    {
        $this->motivoEgreso = RemoveXss($value);
        return $this;
    }

    public function getDepartamento(): ?string
    {
        return HtmlDecode($this->departamento);
    }

    public function setDepartamento(?string $value): static
    {
        $this->departamento = RemoveXss($value);
        return $this;
    }

    public function getCargo(): ?string
    {
        return HtmlDecode($this->cargo);
    }

    public function setCargo(?string $value): static
    {
        $this->cargo = RemoveXss($value);
        return $this;
    }

    public function getCelular1(): ?string
    {
        return HtmlDecode($this->celular1);
    }

    public function setCelular1(?string $value): static
    {
        $this->celular1 = RemoveXss($value);
        return $this;
    }

    public function getCelular2(): ?string
    {
        return HtmlDecode($this->celular2);
    }

    public function setCelular2(?string $value): static
    {
        $this->celular2 = RemoveXss($value);
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

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getHoraEntrada(): ?DateTime
    {
        return $this->horaEntrada;
    }

    public function setHoraEntrada(?DateTime $value): static
    {
        $this->horaEntrada = $value;
        return $this;
    }

    public function getHoraSalida(): ?DateTime
    {
        return $this->horaSalida;
    }

    public function setHoraSalida(?DateTime $value): static
    {
        $this->horaSalida = $value;
        return $this;
    }

    public function getProveedor(): ?int
    {
        return $this->proveedor;
    }

    public function setProveedor(?int $value): static
    {
        $this->proveedor = $value;
        return $this;
    }

    public function getSeguro(): ?int
    {
        return $this->seguro;
    }

    public function setSeguro(?int $value): static
    {
        $this->seguro = $value;
        return $this;
    }

    public function getLevelCemantick(): int
    {
        return $this->levelCemantick;
    }

    public function setLevelCemantick(int $value): static
    {
        $this->levelCemantick = $value;
        return $this;
    }

    public function getEvaluacion(): string
    {
        return $this->evaluacion;
    }

    public function setEvaluacion(string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'evaluacion' value");
        }
        $this->evaluacion = $value;
        return $this;
    }

    // Get login arguments
    public function getLoginArguments(): array
    {
        return [
            "userName" => $this->get('username'),
            "userId" => null,
            "parentUserId" => null,
            "userLevel" => $this->get('level') ?? AdvancedSecurity::ANONYMOUS_USER_LEVEL_ID,
            "userPrimaryKey" => $this->get('Nuser'),
        ];
    }
}
