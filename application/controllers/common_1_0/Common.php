<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
include_once __DIR__ . '/../../models/common_1_0/Niveles_acceso.php';

class Common extends \Restserver\Libraries\REST_Controller {

    protected $usuarioPeticionarioWS;
    protected $isAdministrador = false;
    protected $isGestor = false;

    function __construct() {
        parent::__construct();
        $this->usuarioPeticionarioWS = null;
    }

    protected function getApiKey() {
        return $_SERVER['HTTP_X_API_KEY'];
    }

    /**
     * Se recupera el objeto que identifica el usuario peticionario
     * @return Registro_model $this->UsuarioPeticionarioWS
     */
    protected function getUsuarioPeticionarioWS() {
        if (null == $this->usuarioPeticionarioWS) {
            include_once __DIR__ . '/../../models/registro_1_0/Registro_dao.php';
            $daoReg = new serve\src\registro_1_0\model\Registro_dao();
            $perReg = $daoReg->getPer();
            $ApiKey = $this->getApiKey();
            $this->usuarioPeticionarioWS = $perReg->getUsuarioPorApiKey($ApiKey);
        }
        return $this->usuarioPeticionarioWS;
    }

    protected function asignarPermisos() {
        $Tipo = $this->getUsuarioPeticionarioWS()->getFtn_reg_tipo_usuario_Id();
        $this->isAdministrador = serve\src\common\Niveles_acceso::$usuarioAdministrador != $Tipo;
        $this->isGestor = serve\src\common\Niveles_acceso::$usuarioGestor != $Tipo;
    }

    protected function condicionAcceso() {
        //return $this->isEditor || $this->isAuditor;
    }

    protected function verificarPermisosAcceso() {
        $this->asignarPermisos();
        if (!$this->condicionAcceso()) {
            $data = array('code' => '1', 'error' => 'Permiso insuficientes', 'description' => 'No tiene permisos suficientes para esta acción.');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
        }
    }

}
