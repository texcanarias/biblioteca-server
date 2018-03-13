<?php
namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ .'/../common_1_0/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Proveedor_dao extends Id_unico_dao{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Proveedor_per
     */
    public function getPer(){
        if (NULL == $this->Per){
            include_once (__DIR__.'/Proveedor_per.php');
            return new Proveedor_per();
        }
        return $this->Per;
    }

    
    /**
     * 
     * @return \Proveedor_model
     */
    public function getModel(){
        if(NULL == $this->Model){
            include_once (__DIR__.'/Proveedor_model.php');
            return new Proveedor_model();
        }
        return $this->Model;
        
    }

    /**
     * 
     * @return \Proveedor_mapper
     */
    public function getMapper(){
        if(NULL == $this->Mapper){
            include_once (__DIR__.'/Proveedor_mapper.php');
            return new Proveedor_mapper();
        }
        return $this->Mapper;
    }        
}
