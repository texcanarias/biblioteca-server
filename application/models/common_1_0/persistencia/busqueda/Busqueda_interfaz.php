<?php

namespace serve\src\common\persistencia\busqueda;

interface Busqueda_interfaz {

    public function getBusqueda();

    public function getValorBusqueda($Clave);

    public function setValorBusqueda($Clave, $Valor);

    public function isCampoSeleccionado($Campo);

    public function getParametrosBusqueda();
}
