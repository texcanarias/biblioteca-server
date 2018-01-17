<?php
namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ . '/../proveedor_1_0/Empresa_core_listado_per.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Proveedor_listado_per extends \serve\src\proveedor_1_0\model\Empresa_core_listado_per {
    public function __construct() {
        parent::__construct();
        $this->Tabla = "proveedor";
    }
}