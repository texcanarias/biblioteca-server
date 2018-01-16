<?php

namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ . '/../common/persistencia/Model_base.php');
include_once (__DIR__ . '/../common/Object_to_array_trait.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Empresa_core_model extends \serve\src\common\persistencia\Model_base {
    use \serve\src\common\Object_to_array_trait;
    
    //Datos básicos de un empresa
    protected $Nombre;
    protected $Codigo;
    protected $URL;
    protected $Comentarios;

    //Localización
    protected $Direccion;
    protected $Ciudad;
    protected $Provincia;
    protected $Estado;
    protected $CP;

    //Persona de contacto
    protected $PersonaContacto;
    protected $Telefono;
    protected $Movil;
    protected $Fax;
    protected $Email;
    
    public function __construct() {
        parent::__construct();
    }    

    public function getNombre() {
        return $this->Nombre;
    }

    public function getCodigo() {
        return $this->Codigo;
    }

    public function getURL() {
        return $this->URL;
    }

    public function getComentarios() {
        return $this->Comentarios;
    }

    public function getDireccion() {
        return $this->Direccion;
    }

    public function getCiudad() {
        return $this->Ciudad;
    }

    public function getProvincia() {
        return $this->Provincia;
    }

    public function getEstado() {
        return $this->Estado;
    }

    public function getCP() {
        return $this->CP;
    }

    public function getPersonaContacto() {
        return $this->PersonaContacto;
    }

    public function getTelefono() {
        return $this->Telefono;
    }

    public function getMovil() {
        return $this->Movil;
    }

    public function getFax() {
        return $this->Fax;
    }

    public function getEmail() {
        return $this->Email;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
        return $this;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
        return $this;
    }

    public function setURL($URL) {
        $this->URL = $URL;
        return $this;
    }

    public function setComentarios($Comentarios) {
        $this->Comentarios = $Comentarios;
        return $this;
    }

    public function setDireccion($Direccion) {
        $this->Direccion = $Direccion;
        return $this;
    }

    public function setCiudad($Ciudad) {
        $this->Ciudad = $Ciudad;
        return $this;
    }

    public function setProvincia($Provincia) {
        $this->Provincia = $Provincia;
        return $this;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
        return $this;
    }

    public function setCP($CP) {
        $this->CP = $CP;
        return $this;
    }

    public function setPersonaContacto($PersonaContacto) {
        $this->PersonaContacto = $PersonaContacto;
        return $this;
    }

    public function setTelefono($Telefono) {
        $this->Telefono = $Telefono;
        return $this;
    }

    public function setMovil($Movil) {
        $this->Movil = $Movil;
        return $this;
    }

    public function setFax($Fax) {
        $this->Fax = $Fax;
        return $this;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
        return $this;
    }

    protected function changeKeys($Item) {
        $Diccionario = array("Id" => "id",
                            "Nombre" => "nombre",
                            "Codigo" => "codigo",
                            "URL" => "url",
                            "Comentarios" => "comentarios",
                            "Direccion" => "direccion",
                            "Ciudad" => "ciudad",
                            "Provincia" => "provincia",
                            "Estado" => "estado",
                            "CP" => "cp",
                            "PersonaContacto" => "persona_contacto",
                            "Telefono" => "telefono",
                            "Movil" => "movil",
                            "Fax" => "fax",
                            "Email" => "email");

        $Item =  $this->renombrarArray($Item, $Diccionario);
                
        return $Item;
    }    

}