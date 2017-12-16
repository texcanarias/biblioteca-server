<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__ . '/../euskalit_common_1_0/Euskalit.php';
include_once __DIR__ . '/../../models/common/Niveles_acceso.php';

class Euskalit_empresa extends Euskalit {

    private $IdEmpresa = null;

    function __construct() {
        parent::__construct();
    }

    protected function getIdEmpresa() {
        if (null == $this->IdEmpresa) {
            include_once __DIR__ . '/../../models/euskalit_empresas_1_0/Empresa_dao.php';
            $dao = new serve\src\euskalit_empresas_1_0\model\Empresa_dao();
            $per = $dao->getPer();
            $ApiKey = $this->getApiKey();
            $this->IdEmpresa = $per->getEmpresaPorApiKey($ApiKey);
        }
        return $this->IdEmpresa;
    }

}
