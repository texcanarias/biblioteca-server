<?php
namespace serve\src\cliente_1_0\model;

include_once (__DIR__ .'/../common_1_0/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Cliente_dao extends Id_unico_dao{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Cliente_per
     */
    public function getPer(){
        if (NULL == $this->Per){
            include_once (__DIR__.'/Cliente_per.php');
            return new Cliente_per();
        }
        return $this->Per;
    }

    
    /**
     * 
     * @return \Cliente_model
     */
    public function getModel(){
        if(NULL == $this->Model){
            include_once (__DIR__.'/Cliente_model.php');
            return new Cliente_model();
        }
        return $this->Model;
        
    }

    /**
     * 
     * @return \Cliente_mapper
     */
    public function getMapper(){
        if(NULL == $this->Mapper){
            include_once (__DIR__.'/Cliente_mapper.php');
            return new Cliente_mapper();
        }
        return $this->Mapper;
    }        
}
