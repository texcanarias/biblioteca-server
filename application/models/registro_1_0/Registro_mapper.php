<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Mapper_interfaz.php');
include_once (__DIR__ . '/Registro_model.php');
include_once (__DIR__ . '/../common_1_0/time/Fecha_hora_model.php');

use serve\src\common\estructura\Mapper_interfaz;
use serve\src\registro_1_0\model\Registro_model;
use serve\src\common\time\Fecha_hora_model;

/**
 * Tiene los datos básicos de registro de cada uno de los usuarios
 * del sistema.
 */
class Registro_mapper implements Mapper_interfaz {

    public function constructorModelo() {
        return new Registro_model();
    }

    public function mapper($row) {
        $Item = $this->constructorModelo();
        $Item->setId($row['Id']);
        $Item->setUsuario($row['Usuario']);
        $Item->setNombre($row['Nombre']);
        $Item->setApellidos($row['Apellidos']);
        $Item->setEMail($row['EMail']);
        $Item->setImagenPerfil($row['ImagenPerfil']);
        $Item->setFechaCreacion(Fecha_hora_model::factoriaFechaHoraModel($row['FechaCreacion']));
        $Item->setFechaUltimoAcceso(Fecha_hora_model::factoriaFechaHoraModel($row['FechaUltimoAcceso']));
        $Item->setftn_reg_tipo_usuario_Id($row['ftn_reg_tipo_usuario_Id']);
        $Item->setIdActivo($row["IdActivo"]);
        $Item->setIntentosLogin($row["IntentosLogin"]);
        $Item->setIdIdioma($row["IdIdioma"]);
        $Item->setApiKey($row['ApiKey']);
        return $Item;
    }

}
