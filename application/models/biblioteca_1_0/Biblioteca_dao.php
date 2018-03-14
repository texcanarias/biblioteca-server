<?php
namespace serve\src\proveedor_1_0\model;

include_once (__DIR__ .'/../common_1_0/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Bibilioteca_dao extends Id_unico_dao{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Bibilioteca_per
     */
    public function getPer(){
        if (NULL == $this->Per){
            include_once (__DIR__.'/Bibilioteca_per.php');
            return new Bibilioteca_per();
        }
        return $this->Per;
    }

    
    /**
     * 
     * @return \Bibilioteca_model
     */
    public function getModel(){
        if(NULL == $this->Model){
            include_once (__DIR__.'/Bibilioteca_model.php');
            return new Bibilioteca_model();
        }
        return $this->Model;
        
    }

    /**
     * 
     * @return \Bibilioteca_mapper
     */
    public function getMapper(){
        if(NULL == $this->Mapper){
            include_once (__DIR__.'/Bibilioteca_mapper.php');
            return new Bibilioteca_mapper();
        }
        return $this->Mapper;
    }        
}
