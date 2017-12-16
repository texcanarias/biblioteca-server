<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common/persistencia/Model_base.php');

/**
 * Objeto simple para almacenar datos de registro en la sesi�n.
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Registro_core_model extends \serve\src\common\persistencia\Model_base {

    /**
     * @var string Nombre de usuario
     */
    protected $Usuario;

    /**
     * @var string Nombre del usuario
     */
    protected $Nombre;

    /**
     * @var string Apellidos del usuario
     */
    protected $Apellidos;

    /**
     * @var email Correo electrónico del usuario
     */
    protected $EMail;

    /**
     * @var string Imagen de perfil del usuario
     */
    protected $ImagenPerfil;

    /**
     * @var string Imagen de perfil del usuario
     */
    protected $Skin;

    /**
     * @var Tipos_usuario_model
     */
    protected $Tipos_usuario_model;
    protected $Ftn_reg_tipo_usuario_Id;

    /**
     * @var string Clave generada para la ApiKey
     */
    protected $ApiKey;

    /**
     * @var char(2) Idioma en el que quiere el administrador
     */
    protected $IdIdioma;

    function __construct() {
        $this->Usuario = "";
        $this->Tipos_usuario_model = 0;
        $this->Ftn_reg_tipo_usuario_Id = -1;
        $this->IdIdioma = 'es';
        $this->ImagenPerfil = "";
        $this->ApiKey = "";
    }

    public function getUsuario() {
        return $this->Usuario;
    }

    public function setUsuario($Usuario) {
        $this->Usuario = $Usuario;
        return $this;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
        return $this;
    }

    public function getApellidos() {
        return $this->Apellidos;
    }

    public function setApellidos($Apellidos) {
        $this->Apellidos = $Apellidos;
        return $this;
    }

    public function getNombreApellidos() {
        return $this->Nombre . " " . $this->Apellidos;
    }

    public function getApellidosNombre() {
        return $this->Apellidos . ", " . $this->Nombre;
    }

    public function getEMail() {
        return $this->EMail;
    }

    public function setEMail($EMail) {
        $this->EMail = $EMail;
        return $this;
    }

    function getImagenPerfil() {
        return $this->ImagenPerfil;
    }

    function setImagenPerfil($ImagenPerfil) {
        $this->ImagenPerfil = $ImagenPerfil;
    }

    function tieneImagenPerfil() {
        if ("" == $this->ImagenPerfil) {
            return false;
        }
        return true;
    }

    function getFtn_reg_tipo_usuario_Id() {
        return $this->Ftn_reg_tipo_usuario_Id;
    }

    function setFtn_reg_tipo_usuario_Id($Ftn_reg_tipo_usuario_Id) {
        $this->Ftn_reg_tipo_usuario_Id = $Ftn_reg_tipo_usuario_Id;
        return $this;
    }

    public function getTipos_usuario_model() {
        if (!$this->Tipos_usuario_model) {
            include_once ('./application/models/registro/Tipos_usuario_per.php');
            include_once ('./application/models/registro/Tipos_usuario_model.php');
            include_once ('./application/models/registro/Tipos_usuario_mapper.php');
            $Item = new Tipos_usuario_per();
            $Seed = new Tipos_usuario_model();
            $Seed->setId($this->Ftn_reg_tipo_usuario_Id);
            $this->Tipos_usuario_model = $Item->getItem($Seed, new Tipos_usuario_mapper(), new Tipos_usuario_model());
        }
        return $this->Tipos_usuario_model;
    }

    function getIdIdioma() {
        return $this->IdIdioma;
    }

    function setIdIdioma($IdIdioma) {
        $this->IdIdioma = $IdIdioma;
        return $this;
    }

    public function getApiKey() {
        return $this->ApiKey;
    }

    public function setApiKey($ApiKey) {
        $this->ApiKey = $ApiKey;
        return $this;
    }

}
