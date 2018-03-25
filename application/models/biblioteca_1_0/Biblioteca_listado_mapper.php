<?php
namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ .'/../common_1_0/estructura/Mapper_interfaz.php');
include_once (__DIR__.'/Biblioteca_listado_model.php');

use serve\src\common\estructura\Mapper_interfaz;

class Biblioteca_listado_mapper implements Mapper_interfaz{
    /**
     * 
     * @return \serve\src\bibilioteca_1_0\model\Biblioteca_core_listado_model
     */
    public function constructorModelo() {
        return new Biblioteca_listado_model();
    }
    
    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['id']);
        $Item->setNombre($row['nombre']);
        $Item->setAutor($row['autor']);
        $Item->setPosicion($row['posicion']);
        $Item->setLeido($row['leido']);

        return $Item;
    }

   
}