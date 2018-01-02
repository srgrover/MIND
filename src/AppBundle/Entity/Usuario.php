<?php
namespace AppBundle\Entity;
//use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="Usuario")
 */
class Usuario extends BaseUser {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @var boolean
     */
    protected $admin = false;

//    /**
//     * @var string
//     *
//     * @ORM\Column(type="string", unique=true, nullable=false)
//     * @Assert\NotBlank(
//     *     message = "El email no puede estar vacío"
//     * )
//     * @Assert\Email(
//     *     message = "El email {{ value }} no es válido.",
//     * )
//     */
//    protected $email;

//    /**
//     * @ORM\Column(type="string", nullable=false)
//     * @Assert\Length(
//     *     min = 8,
//     *     minMessage = "La contraseña debe tener como mínimo 8 caracteres"
//     * )
//     *
//     * @var string
//     */
//    protected $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $tokenValidity;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(
     *     message = "El nombre no puede estar vacío"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Un nombre no puede contener un dígito"
     * )
     *
     * @var string
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(
     *     message = "Los apellidos no pueden estar vacíos"
     * )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="El apellido no puede contener un dígito"
     * )
     *
     * @var string
     */
    protected $apellidos;

    /**
     * @ORM\Column(type="date", nullable=false)
     *
     * @var /date
     */
    protected $fechaNacimiento;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $imagenPerfil;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Objeto", mappedBy="usuario")
     *
     * @var Objeto
     */
    protected $objetos;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @var boolean
     */
    protected $estado = false;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_USER');
    }

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    protected $activacion;

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        $roles = ["ROLE_USER"];     //Todos los usuarios son ROLE_USER
        if($this->isAdmin()){
            $roles[] = "ROLE_ADMIN";
        }
        return $roles;
    }

    public function eraseCredentials()
    {
    }

    public function __toString()
    {
        return $this->getNombre() . ' ' . $this->getApellidos();
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password
        ));
    }

    public function  unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param bool $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getTokenValidity()
    {
        return $this->tokenValidity;
    }

    /**
     * @param mixed $tokenValidity
     */
    public function setTokenValidity($tokenValidity)
    {
        $this->tokenValidity = $tokenValidity;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return /date
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param /date $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * @return string
     */
    public function getImagenPerfil()
    {
        return $this->imagenPerfil;
    }

    /**
     * @param string $imagenPerfil
     */
    public function setImagenPerfil($imagenPerfil)
    {
        $this->imagenPerfil = $imagenPerfil;
    }
//    /**
//     * @return string
//     */
//    public function getImagenFondo()
//    {
//        return $this->imagenFondo;
//    }
//    /**
//     * @param string $imagenFondo
//     */
//    public function setImagenFondo($imagenFondo)
//    {
//        $this->imagenFondo = $imagenFondo;
//    }
    /**
     * @return boolean
     */
    public function isEstado()
    {
        return $this->estado;
    }
    /**
     * @param boolean $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    /**
     * @return \DateTime
     */
    public function getActivacion()
    {
        return $this->activacion;
    }
    /**
     * @param \DateTime $activacion
     */
    public function setActivacion($activacion)
    {
        $this->activacion = $activacion;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
}