<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common_1_0/persistencia/Primitiva_per.php');

use serve\src\common\persistencia\Model_interfaz;

/**
 * Sistema de persistencia del Registro
 */
class Biblioteca_per extends \serve\src\common\persistencia\Primitiva_per {

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = "bib_biblioteca";
    }

    protected function setItemBuildSql() {
        return "nombre = :NOMBRE,
                autor = :AUTOR,
                leido = :LEIDO ";
    }

    protected function setItemBuildBindParam(\PDOStatement &$sth, Model_interfaz $Item) {
        $sth->bindValue(':NOMBRE', $Item->getNombre(), \PDO::PARAM_STR);
        $sth->bindValue(':AUTOR', $Item->getAutor(), \PDO::PARAM_STR);
        $sth->bindValue(':LEIDO', $Item->getLeido(), \PDO::PARAM_BOOL);
    }

}
