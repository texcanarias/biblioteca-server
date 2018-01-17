<?php
namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ .'/../common/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Proveedor_listado_dao extends Id_unico_dao{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Proveedor_listado_per
     */
    public function getPer(){
        if (NULL == $this->Per){
            include_once (__DIR__.'/Proveedor_listado_per.php');
            return new Proveedor_listado_per();
        }
        return $this->Per;
    }

    
    /**
     * 
     * @return \Proveedor_listado_model
     */
    public function getModel(){
        if(NULL == $this->Model){
            include_once (__DIR__.'/Proveedor_listado_model.php');
            return new Proveedor_listado_model();
        }
        return $this->Model;
        
    }

    /**
     * 
     * @return \Proveedor_listado_mapper
     */
    public function getMapper(){
        if(NULL == $this->Mapper){
            include_once (__DIR__.'/Proveedor_listado_mapper.php');
            return new Proveedor_listado_mapper();
        }
        return $this->Mapper;
    }        
}
