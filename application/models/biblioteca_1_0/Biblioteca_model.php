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
class Bibilioteca_core_model extends \serve\src\common\persistencia\Model_base {
    use \serve\src\common\Object_to_array_trait;
    
    protected $Nombre;
    protected $Autor;
    protected $Leido;
    
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
    }

    function setAutor($Autor) {
        $this->Autor = $Autor;
    }

    function setLeido($Leido) {
        $this->Leido = $Leido;
    }

    protected function changeKeys($Item) {
        $Diccionario = array("Id" => "id",
                            "Nombre" => "nombre",
                            "Autor" => "autor",
                            "Leido" => "leido");                
        return $Item;
    }    

}