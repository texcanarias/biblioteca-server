<?php
namespace serve\src\cliente_1_0\model;

include_once (__DIR__ . '/../proveedor_1_0/Empresa_core_mapper.php');
include_once (__DIR__ . '/../cliente_1_0/Cliente_model.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Cliente_mapper extends \serve\src\proveedor_1_0\model\Empresa_core_mapper {
    public function __construct() {
        parent::__construct();
    }

    public function constructorModelo() {
        return new Cliente_model();
    }    
    
    public function mapper($row) {
        $Item = parent::mapper($row);
        $Item->setDiasVencimiento($row['DiasVencimiento']);
        $Item->setTipo($row['Tipo']);               
        return $Item;
    }    
}