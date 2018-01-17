<?php

namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ . '/../common/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common/persistencia/Primitiva_listado_per.php');

/**
 * Sistema de persistencia del Registro
 */
class Empresa_core_listado_per extends \serve\src\common\persistencia\Primitiva_listado_per {

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = ""; 
    }

    function factoriaMappeador(){
        if(!$this->Mappeador){
            include_once (__DIR__.'/Empresa_core_listado_mapper.php');
            $this->Mappeador = new Empresa_core_listado_mapper();
        }
        return $this->Mappeador;
    }
        
    function getBindParam(&$sth){
    }
    
    function buildSqlBusqueda($ClavesBusqueda) {
        $SqlBusqueda = array();
        return $SqlBusqueda;
    }    
    
    function getSqlItem(){
        return 'SELECT * FROM ' . $this->Tabla;
    }    

}