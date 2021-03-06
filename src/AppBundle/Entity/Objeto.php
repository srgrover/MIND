<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */
class Objeto {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(
     *     message = "El nombre del objeto no puede estar vacío"
     * )
     *
     * @var string
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(
     *     message = "La ubicación del objeto no puede estar vacía"
     * )
     *
     * @var string
     */
    protected $ubicacion;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @var boolean
     */
    protected $favorito = 0;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    protected $fecha;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @var boolean
     */
    protected $activo = 1;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="objetos")
     *
     * @var Usuario
     */
    protected $usuario;

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
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * @param string $ubicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     * @return bool
     */
    public function isFavorito()
    {
        return $this->favorito;
    }

    /**
     * @param bool $favorito
     */
    public function setFavorito($favorito)
    {
        $this->favorito = $favorito;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return bool
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param bool $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

}