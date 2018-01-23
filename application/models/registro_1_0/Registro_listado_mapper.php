<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Mapper_interfaz.php');

use serve\src\common\estructura\Mapper_interfaz;

class Registro_listado_mapper implements Mapper_interfaz {

    public function constructorModelo() {
        
    }

    public function mapper($row) {
        include_once (__DIR__ . '/Registro_listado_model.php');
        include_once (__DIR__ . '/Registro_mapper.php');
        include_once (__DIR__ . '/Tipos_usuario_mapper.php');
        $MapperRegistro = new Registro_mapper();
        $MapperTipo = new Tipos_usuario_mapper();
        $Registro = $MapperRegistro->mapper($row);
        $row['Nombre'] = $row['NombreTipoUsuario'];
        $row['Id'] = $row['ftn_reg_tipo_usuario_Id'];
        $TipoUsuario = $MapperTipo->mapper($row);
        $Item = new Registro_listado_model();
        $Item->setRegistro($Registro)->setTipoUsuario($TipoUsuario);
        return $Item;
    }

}
