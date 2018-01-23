<?php
namespace serve\src\euskalit_Cliente_1_0\model;

include_once (__DIR__ .'/../common_1_0/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Cliente_listado_dao extends Id_unico_dao{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Cliente_listado_per
     */
    public function getPer(){
        if (NULL == $this->Per){
            include_once (__DIR__.'/Cliente_listado_per.php');
            return new Cliente_listado_per();
        }
        return $this->Per;
    }

    
    /**
     * 
     * @return \Cliente_listado_model
     */
    public function getModel(){
        if(NULL == $this->Model){
            include_once (__DIR__.'/Cliente_listado_model.php');
            return new Cliente_listado_model();
        }
        return $this->Model;
        
    }

    /**
     * 
     * @return \Cliente_listado_mapper
     */
    public function getMapper(){
        if(NULL == $this->Mapper){
            include_once (__DIR__.'/Cliente_listado_mapper.php');
            return new Cliente_listado_mapper();
        }
        return $this->Mapper;
    }        
}
