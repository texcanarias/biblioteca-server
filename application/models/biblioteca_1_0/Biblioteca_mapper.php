<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Mapper_interfaz.php');
include_once (__DIR__.'/Biblioteca_model.php');

use serve\src\common\estructura\Mapper_interfaz;

/**
 * Tiene los datos básicos de registro de cada uno de los usuarios
 * del sistema.
 */
class Biblioteca_mapper implements Mapper_interfaz {

    public function __construct() {
    }
    
    public function constructorModelo() {
        return new Biblioteca_model();
    }

    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['id']);
        $Item->setNombre($row['nombre']);
        $Item->setAutor($row['autor']);
        $Item->setLeido($row['leido']);

        return $Item;
    }

}
