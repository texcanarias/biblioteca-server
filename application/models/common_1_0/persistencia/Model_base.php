<?php

namespace serve\src\common\persistencia;

include_once (__DIR__ . '/../../common/persistencia/Model_interfaz.php');

class Model_base implements Model_interfaz {

    /**
     * @var integer Identificador de persistencia
     */
    protected $Id;

    public function __construct() {
        $this->Id = null;
    }

    public function getId() {
        return $this->Id;
    }

    public function setId($Id = null) {
        $this->Id = $Id;
        return $this;
    }

    public function isNuevo() {
        return (0 == $this->Id || null == $this->Id || -1 == $this->Id ) ? true : false;
    }

}
