<?php
namespace serve\src\cliente_1_0\model;

include_once (__DIR__ . '/../proveedor_1_0/Empresa_core_model.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Cliente_model extends \serve\src\proveedor_1_0\model\Empresa_core_model {
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


}