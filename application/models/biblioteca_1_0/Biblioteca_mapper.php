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

        //Datos básicos de un empresa
        $Item->setNombre($row['nombre']);
        $Item->setCodigo($row['codigo']);
        $Item->setURL($row['URL']);
        $Item->setComentarios($row['Comentarios']);

        //Localización
        $Item->setDireccion($row['Direccion']);
        $Item->setCiudad($row['Ciudad']);
        $Item->setProvincia($row['Provincia']);
        $Item->setEstado($row['Estado']);
        $Item->setCP($row['CP']);

        //Persona de contacto
        $Item->setPersonaContacto($row['PersonaContacto']);
        $Item->setTelefono($row['Telefono']);
        $Item->setMovil($row['Movil']);
        $Item->setFax($row['Fax']);
        $Item->setEmail($row['email']);

        return $Item;
    }

}
