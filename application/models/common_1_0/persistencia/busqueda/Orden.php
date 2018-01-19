<?php

namespace serve\src\common\persistencia\busqueda;

include_once (__DIR__ . '/Orden_interfaz.php');

use Orden_interfaz;

class Orden_stateless implements \serve\src\common\persistencia\busqueda\Orden_interfaz {

    private $Orden;

    /**
     * @var Array con los parámetros de orden. 'Nombre en el listado' => 'Nombre en la tabla'
     */
    private $ParametrosOrden;

    /**
     * La orientación por defecto que va a tener el orden.
     * @var char 'asc' o 'desc'
     */
    private $OrientacionDefecto;

    public function __construct() {
        $this->Orden = array();
        $this->ParametrosOrden = array();
        $this->setOrientacionAsc();
    }

    public function setOrientacionAsc() {
        $this->OrientacionDefecto = 'asc';
        return $this;
    }

    public function setOrientacionDesc() {
        $this->OrientacionDefecto = 'desc';
        return $this;
    }

    public function getOrden() {
        return $this->Orden;
    }

    public function setOrden($Orden) {
        $this->Orden = $Orden;
        return $this;
    }

    public function getCampoSQL($Campo) {
        return $this->ParametrosOrden[$Campo];
    }

    public function getCampoOrden() {
        return $this->Orden['orden'];
    }

    public function isNadaUnCampoDeOrdenacion() {
        return isset($this->ParametrosOrden['nada']);
    }

    public function getCampoOrientacion() {
        return $this->Orden['orientacion'];
    }

    public function getParametrosOrden() {
        return $this->ParametrosOrden;
    }

    /**
     * 
     * @param type $Parametros
     * @return Orden
     */
    public function Preparacion($Parametros) {
        $this->ParametrosOrden = $Parametros;

        reset($Parametros);
        $this->Orden = array(
            "orden" => key($Parametros),
            "orientacion" => $this->OrientacionDefecto
        );

        return $this;
    }

}
