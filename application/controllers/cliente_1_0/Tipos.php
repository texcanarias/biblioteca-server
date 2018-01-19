<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__ . '/../common_1_0/Common.php';
include_once __DIR__ . '/../../models/common/Niveles_acceso.php';

class Tipos extends Common {

    function __construct() {
        parent::__construct();
    }

    protected function condicionAcceso() {
        return $this->isAdministrador || $this->isGestor; 
    }

    /**
     * Listado de los tipos de empresa 
     * Como respuesta se enviará un email con los datos de la nueva contraseña
     */
    public function index_get() {
        $this->verificarPermisosAcceso();

        $data = array();
        $data[] = array("id" => "1", "tipo" => "Imprenta");
        $data[] = array("id" => "2", "tipo" => "Serigrafía");
        $data[] = array("id" => "3", "tipo" => "Repografía");
        $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

}
