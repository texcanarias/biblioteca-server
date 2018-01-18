<?php
namespace serve\src\cliente_1_0\model;

include_once (__DIR__ . '/../proveedor_1_0/Empresa_core_per.php');

/**
 * Objeto simple para almacenar datos de empresas relacionadas
 * @author usuario
 * @version 1.0
 * @created 17-feb-2015 16:09:41
 */
class Cliente_per extends \serve\src\proveedor_1_0\model\Empresa_core_per {
    public function __construct() {
        parent::__construct();
        $this->Tabla = "cliente";
    }

    private function setItemBuildSql(){
        return parent::setItemBuildSql() .
                "dias_vencimiento = :DIAS_VENCIMIENTO,
                tipo = :TIPO ";
    }

    
 private function setItemBuildBindParam(\PDOStatement &$sth, Model_interfaz $Item) {
        parent::setItemBuildBindParam($sth,$Item);
        $sth->bindValue(':DIAS_VENCIMIENTO', $Item->getDiasVencimiento(), \PDO::PARAM_INT);
        $sth->bindValue(':TIPO', $Item->getTipo(), \PDO::PARAM_INT);
    }    
}