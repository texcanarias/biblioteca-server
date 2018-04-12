<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/persistencia/Model_base.php');
include_once (__DIR__ . '/../common_1_0/Object_to_array_trait.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Biblioteca_model extends \serve\src\common\persistencia\Model_base {
    use \serve\src\common\Object_to_array_trait;
    
    protected $Nombre;
    protected $Autor;
    protected $Posicion;
    protected $Leido;
    protected $Origen;
    
    
    public function __construct() {
        parent::__construct();
    }    

    function getNombre() {
        return $this->Nombre;
    }

    function getAutor() {
        return $this->Autor;
    }

    function getLeido() {
        return $this->Leido;
    }

    function setNombre($Nombre) {
        $this->Nombre = $Nombre;
        return $this;
    }

    function setAutor($Autor) {
        $this->Autor = $Autor;
        return $this;
    }

    function setLeido($Leido) {
        $this->Leido = $Leido;
        return $this;
    }
    
    public function getPosicion() {
        return $this->Posicion;
    }

    public function setPosicion($Posicion) {
        $this->Posicion = $Posicion;
        return $this;
    }
    
    function getOrigen() {
        return $this->Origen;
    }

    function setOrigen($Origen) {
        $this->Origen = $Origen;
    }

    
    
    protected function changeKeys($Item) {
        $Diccionario = array("Id" => "id",
                            "Nombre" => "nombre",
                            "Autor" => "autor",
                            "Posicion" => "posicion",
                            "Leido" => "leido",
                            "Origen" => "origen");    
        $Item =  $this->renombrarArray($Item, $Diccionario);
        
        $Item = $this->adaptarBooleano($Item, array('leido'));
        
        return $Item;
    }    

}