<?php

namespace serve\src\common\persistencia\busqueda;

interface Paginacion_interfaz {

    public function getDocumentosPorPagina();

    public function getDesplazamiento();

    public function setDocumentosPorPagina($DocumentosPorPagina);

    public function setDesplazamiento($Desplazamiento);
}
