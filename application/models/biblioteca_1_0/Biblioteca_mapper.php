<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Mapper_interfaz.php');

use serve\src\common\estructura\Mapper_interfaz;

/**
 * Tiene los datos básicos de registro de cada uno de los usuarios
 * del sistema.
 */
abstract class Bibilioteca_core_mapper implements Mapper_interfaz {

    public function __construct() {
    }
    
    abstract public function constructorModelo();

    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['id']);
        $Item->setNombre($row['nombre']);
        $Item->setAutor($row['autor']);
        $Item->setLeido($row['leido']);

        return $Item;
    }

}
