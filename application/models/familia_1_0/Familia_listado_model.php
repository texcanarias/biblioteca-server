<?php

namespace serve\src\familia_1_0\model;

include_once (__DIR__ . '/../common_1_0/persistencia/Model_base.php');
include_once (__DIR__ . '/../common_1_0/Object_to_array_trait.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Familia_listado_model extends \serve\src\common\persistencia\Model_base {
    use \serve\src\common\Object_to_array_trait;
    
    protected $IdPadre;
    protected $Nombre;
    protected $Hijos;
    
    public function __construct() {
        parent::__construct();
        $this->Hijos = [];
    }    

    
    public function getNombre() {
        return $this->Nombre;
    }
    
    /**
     * @todo Posibilidar la capacidad de hacer una carga lazy 
     * @return type
     */
    public function getHijos(){
        return  $this->Hijos;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
        return $this;
    }
    
    public function setHijos($Hijos){
        $this->Hijos = $Hijos;
        return $this;
    }
    
    function getIdPadre() {
        return $this->IdPadre;
    }

    function setIdPadre($IdPadre) {
        $this->IdPadre = $IdPadre;
    }

        
    protected function changeKeys($Item) {
        $Diccionario = array("Id" => "id",
                            "Nombre" => "nombre");

        $Item =  $this->renombrarArray($Item, $Diccionario);
                
        return $Item;
    }    
}