<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common/estructura/Mapper_interfaz.php');

/**
 * Objeto simple para almacenar datos de registro en la sesi�n.
 * @author usuario
 * @version 1.0
 */
class Registro_core_mapper implements Mapper_interfaz {

    public function constructorModelo() {
        return new Registro_core_model();
    }

    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['Id']);
        $Item->setUsuario($row['Usuario']);
        $Item->setNombre($row['Nombre']);
        $Item->setApellidos($row['Apellidos']);
        $Item->setEMail($row['EMail']);
        $Item->setftn_reg_tipo_usuario_Id($row['ftn_reg_tipo_usuario_Id']);
        $Item->setIdIdioma($row["IdIdioma"]);
        $Item->setImagenPerfil($row["ImagenPerfil"]);
        $Item->setApiKey($row['ApiKey']);
        return $Item;
    }

}
