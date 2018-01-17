<?php
namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ .'/../common/estructura/Mapper_interfaz.php');
include_once (__DIR__.'/Empresa_core_listado_model.php');

use serve\src\common\estructura\Mapper_interfaz;

class Empresa_core_listado_mapper implements Mapper_interfaz{
    /**
     * 
     * @return \serve\src\proveedor_1_0\model\Empresa_core_listado_model
     */
    public function constructorModelo() {
        return new Empresa_core_listado_model();
    }
    
    
    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['id']);
        $Item->setNombre($row['nombre']);
        $Item->setCodigo($row['codigo']);
        $Item->setTelefono($row['Telefono']);

        return $Item;
    }

}