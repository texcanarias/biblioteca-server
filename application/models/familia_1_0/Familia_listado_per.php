<?php

namespace serve\src\familia_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common_1_0/persistencia/Primitiva_listado_per.php');

/**
 * Sistema de persistencia del Registro
 */
class Familia_listado_per extends \serve\src\common\persistencia\Primitiva_listado_per {

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = "familia"; 
    }

    function factoriaMappeador(){
        if(!$this->Mappeador){
            include_once (__DIR__.'/Familia_listado_mapper.php');
            $this->Mappeador = new Familia_listado_mapper();
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