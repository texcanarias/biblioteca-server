<?php

namespace serve\src\common\persistencia\busqueda;

include_once (__DIR__ . '/Busqueda_interfaz.php');

use Busqueda_interfaz;

class Busqueda implements \serve\src\common\persistencia\busqueda\Busqueda_interfaz {

    private $Busqueda;

    /**
     * @var Array con los parámetros de busqueda. 'Nombre del parámetro' => 'Valor por defecto'
     */
    private $ParametrosBusqueda;

    public function __construct() {
        $this->Busqueda = array();
        $this->ParametrosBusqueda = array();
    }

    public function Preparacion($Parametros) {
        $this->Busqueda = $Parametros;

        return $this;
    }

    public function getBusqueda() {
        return $this->Busqueda;
    }

    public function getValorBusqueda($Clave) {
        return (isset($this->Busqueda[$Clave]) ? $this->Busqueda[$Clave] : "");
    }

    public function setValorBusqueda($Clave, $Valor) {
        $this->Busqueda[$Clave] = $Valor;
    }

    public function isCampoSeleccionado($Campo) {
        if (isset($this->Busqueda['buscar_por'])) {
            return in_array($Campo, $this->Busqueda['buscar_por']) ? true : false;
        }
        return false;
    }

    public function getParametrosBusqueda() {
        return $this->ParametrosBusqueda;
    }

}
