<?php
namespace serve\src\familia_1_0\model;

include_once (__DIR__ .'/../common_1_0/estructura/Mapper_interfaz.php');
include_once (__DIR__.'/Empresa_core_listado_model.php');

use serve\src\common\estructura\Mapper_interfaz;

class Familia_listado_mapper implements Mapper_interfaz{
    /**
     * 
     * @return \serve\src\familia_1_0\model\Familia_listado_model
     */
    public function constructorModelo() {
        return new Familia_listado_model();
    }
    
    
    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['Id']);
        $Item->setNombre($row['Nombre']);
        $Item->setIdPadre($row['IdPadre']);

        return $Item;
    }

}