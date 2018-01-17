<?php
namespace serve\src\cliente_1_0\model;

include_once (__DIR__ . '/../proveedor_1_0/Empresa_core_listado_mapper.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Cliente_listado_mapper extends \serve\src\proveedor_1_0\model\Empresa_core_listado_mapper {
    public function __construct() {
        parent::__construct();
    }
}