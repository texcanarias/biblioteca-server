<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common_1_0/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Registro_dao extends Id_unico_dao {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Registro_per
     */
    public function getPer() {
        if (NULL == $this->Per) {
            include_once (__DIR__ . '/Registro_per.php');
            return new Registro_per();
        }
        return $this->Per;
    }

    /**
     * 
     * @return \Registro_model
     */
    public function getModel() {
        if (NULL == $this->Model) {
            include_once (__DIR__ . '/Registro_model.php');
            return new Registro_model();
        }
        return $this->Model;
    }

    /**
     * 
     * @return \Registro_mapper
     */
    public function getMapper() {
        if (NULL == $this->Mapper) {
            include_once (__DIR__ . '/Registro_mapper.php');
            return new Registro_mapper();
        }
        return $this->Mapper;
    }

}
