<?php

namespace serve\src\common\persistencia;

interface Model_interfaz {

    public function getId();

    public function setId($Id);

    public function isNuevo();
}
