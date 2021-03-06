<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common_1_0/persistencia/Primitiva_listado_per.php');

/**
 * Sistema de persistencia del Registro
 */
class Biblioteca_listado_per extends \serve\src\common\persistencia\Primitiva_listado_per {

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = "bib_biblioteca"; 
    }

    function factoriaMappeador(){
        if(!$this->Mappeador){
            include_once (__DIR__.'/Biblioteca_listado_mapper.php');
            $this->Mappeador = new Biblioteca_listado_mapper();
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