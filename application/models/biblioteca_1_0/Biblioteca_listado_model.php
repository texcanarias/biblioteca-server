<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/persistencia/Model_base.php');
include_once (__DIR__.'/Biblioteca_model.php');

/**
 * Objeto simple para almacenar datos de bibliotecas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Biblioteca_listado_model extends \serve\src\biblioteca_1_0\model\Biblioteca_model {
    
    public function __construct() {
        parent::__construct();
    }    
}