<?php

namespace serve\src\common\persistencia\busqueda;

interface Orden_interfaz {

    public function setOrientacionAsc();

    public function setOrientacionDesc();

    public function getOrden();

    public function getCampoSQL($Campo);

    public function getCampoOrden();

    public function isNadaUnCampoDeOrdenacion();

    public function getCampoOrientacion();

    public function getParametrosOrden();
}
