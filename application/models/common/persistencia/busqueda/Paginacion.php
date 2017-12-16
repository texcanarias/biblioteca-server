<?php

namespace serve\src\common\persistencia\busqueda;

include_once (__DIR__ . '/Paginacion_interfaz.php');

use Paginacion_interfaz;

class Paginacion_stateless implements \serve\src\common\persistencia\busqueda\Paginacion_interfaz {

    /**
     * @var int Documentos por página
     */
    private $DocumentosPorPagina;

    /**
     * @var int Desplazamiento 
     */
    private $Desplazamiento;

    /**
     * Recupera el número de páginas por defecto y/o recupera los datos de la sesion
     * 
     * @param int $CodigoSession
     * @param int $Configuracion
     */
    public function __construct() {
        $this->DocumentosPorPagina = 0;
        $this->Desplazamiento = 0;
    }

    public function getDocumentosPorPagina() {
        return $this->DocumentosPorPagina;
    }

    public function getDesplazamiento() {
        return $this->Desplazamiento;
    }

    public function setDocumentosPorPagina($DocumentosPorPagina) {
        $this->DocumentosPorPagina = $DocumentosPorPagina;
    }

    public function setDesplazamiento($Desplazamiento) {
        $this->Desplazamiento = $Desplazamiento;
    }

}
