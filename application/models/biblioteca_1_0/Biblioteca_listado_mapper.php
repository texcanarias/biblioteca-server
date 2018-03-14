<?php
namespace serve\src\bibilioteca_1_0\model;

include_once (__DIR__ .'/../common_1_0/estructura/Mapper_interfaz.php');
include_once (__DIR__.'/Bibilioteca_core_listado_model.php');

use serve\src\common\estructura\Mapper_interfaz;

class Bibilioteca_core_listado_mapper implements Mapper_interfaz{
    /**
     * 
     * @return \serve\src\bibilioteca_1_0\model\Bibilioteca_core_listado_model
     */
    public function constructorModelo() {
        return new Bibilioteca_core_listado_model();
    }
   
}