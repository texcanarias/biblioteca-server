<?php
namespace serve\src\cliente_1_0\model;

include_once (__DIR__ . '/../proveedor_1_0/Empresa_core_model.php');
include_once (__DIR__ . '/../common_1_0/Object_to_array_trait.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Cliente_model extends \serve\src\proveedor_1_0\model\Empresa_core_model {
    use \serve\src\common\Object_to_array_trait;
    
    /**
     * Días de vencimiento de las facturas
     * @var int
     */
    protected $DiasVencimiento;
    
    /**
     * @todo Hay que determinar que hace este campo
     * @var int
     */
    protected $Tipo;       
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getDiasVencimiento() {
        return $this->DiasVencimiento;
    }

    public function getTipo() {
        return $this->Tipo;
    }

    public function setDiasVencimiento($DiasVencimiento) {
        $this->DiasVencimiento = $DiasVencimiento;
        return $this;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
        return $this;
    }

protected function changeKeys($Item) {
        $Diccionario = array("Id" => "id",
                            "Nombre" => "nombre",
                            "Codigo" => "codigo",
                            "URL" => "url",
                            "Comentarios" => "comentarios",
                            "Direccion" => "direccion",
                            "Ciudad" => "ciudad",
                            "Provincia" => "provincia",
                            "Estado" => "estado",
                            "CP" => "cp",
                            "PersonaContacto" => "persona_contacto",
                            "Telefono" => "telefono",
                            "Movil" => "movil",
                            "Fax" => "fax",
                            "Email" => "email",
                            "DiasVencimiento" => "dias_vencimiento",
                            "Tipo" => "tipo");

        $Item =  $this->renombrarArray($Item, $Diccionario);
                
        return $Item;
    }    
}