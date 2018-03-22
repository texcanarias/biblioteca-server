<?php
namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ .'/../common_1_0/persistencia/Id_unico_dao.php');

use serve\src\common\persistencia\Id_unico_dao;

class Biblioteca_dao extends Id_unico_dao{
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return \Biblioteca_per
     */
    public function getPer(){
        if (NULL == $this->Per){
            include_once (__DIR__.'/Biblioteca_per.php');
            return new Biblioteca_per();
        }
        return $this->Per;
    }

    
    /**
     * 
     * @return \Biblioteca_model
     */
    public function getModel(){
        if(NULL == $this->Model){
            include_once (__DIR__.'/Biblioteca_model.php');
            return new Biblioteca_model();
        }
        return $this->Model;
        
    }

    /**
     * 
     * @return \Biblioteca_mapper
     */
    public function getMapper(){
        if(NULL == $this->Mapper){
            include_once (__DIR__.'/Biblioteca_mapper.php');
            return new Biblioteca_mapper();
        }
        return $this->Mapper;
    }        
}
