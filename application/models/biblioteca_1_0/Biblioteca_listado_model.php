<?php

namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ . '/../common_1_0/persistencia/Model_base.php');
include_once (__DIR__ . '/../common_1_0/Object_to_array_trait.php');

/**
 * Objeto simple para almacenar datos de bibliotecas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Bibilioteca_core_listado_model extends \serve\src\proveedor_1_0\model\Biblioteca_model {
    use \serve\src\common\Object_to_array_trait;
    
    public function __construct() {
        parent::__construct();
    }    
}