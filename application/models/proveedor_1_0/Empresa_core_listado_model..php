<?php

namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ . '/../common/persistencia/Model_base.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Empresa_core_listado_model extends \serve\src\common\persistencia\Model_base {
    protected $Nombre;
    protected $Codigo;
    protected $Telefono;
    
    public function __construct() {
        parent::__construct();
    }    

    public function getNombre() {
        return $this->Nombre;
    }

    public function getCodigo() {
        return $this->Codigo;
    }

    public function getTelefono() {
        return $this->Telefono;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
        return $this;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
        return $this;
    }

    public function setTelefono($Telefono) {
        $this->Telefono = $Telefono;
        return $this;
    }
}