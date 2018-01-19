<?php

namespace serve\src\common\estructura;

interface Mapper_interfaz {

    public function constructorModelo();

    public function mapper($row);
}
