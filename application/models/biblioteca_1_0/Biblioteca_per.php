<?php

namespace serve\src\biblioteca_1_0\model;

include_once (__DIR__ . '/../common_1_0/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common_1_0/persistencia/Primitiva_per.php');

use serve\src\common\persistencia\Model_interfaz;

/**
 * Sistema de persistencia del Registro
 */
class Bibilioteca_core_per extends \serve\src\common\persistencia\Primitiva_per {

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = "";
    }

    protected function setItemBuildSql() {
        return "nombre = :NOMBRE,
                codigo = :CODIGO,
                Direccion = :DIRECCION,
                Ciudad = :CIUDAD,
                Provincia = :PROVINCIA,
                Estado = :ESTADO,
                CP = :CP,
                PersonaContacto = :PERSONA_CONTACTO,
                Telefono = :TELEFONO,
                Movil = :MOVIL,
                Fax = :FAX,
                email = :EMAIL,
                URL = :URL,
                Comentarios = :COMENTARIOS ";
    }

    protected function setItemBuildBindParam(\PDOStatement &$sth, Model_interfaz $Item) {
        $sth->bindValue(':NOMBRE', $Item->getNombre(), \PDO::PARAM_STR);
        $sth->bindValue(':CODIGO', $Item->getCodigo(), \PDO::PARAM_STR);
        $sth->bindValue(':DIRECCION', $Item->getDireccion(), \PDO::PARAM_STR);
        $sth->bindValue(':CIUDAD', $Item->getCiudad(), \PDO::PARAM_STR);
        $sth->bindValue(':PROVINCIA', $Item->getProvincia(), \PDO::PARAM_STR);
        $sth->bindValue(':ESTADO', $Item->getEstado(), \PDO::PARAM_STR);
        $sth->bindValue(':CP', $Item->getCP(), \PDO::PARAM_STR);
        $sth->bindValue(':PERSONA_CONTACTO', $Item->getPersonaContacto(), \PDO::PARAM_STR);
        $sth->bindValue(':TELEFONO', $Item->getTelefono(), \PDO::PARAM_STR);
        $sth->bindValue(':MOVIL', $Item->getMovil(), \PDO::PARAM_STR);
        $sth->bindValue(':FAX', $Item->getFax(), \PDO::PARAM_STR);
        $sth->bindValue(':EMAIL', $Item->getEmail(), \PDO::PARAM_STR);
        $sth->bindValue(':URL', $Item->getUrl(), \PDO::PARAM_STR);
        $sth->bindValue(':COMENTARIOS', $Item->getComentarios(), \PDO::PARAM_STR);
    }

}
