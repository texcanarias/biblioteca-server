<?php

namespace serve\src\euskalit_empresas_1_0\model;

include_once (__DIR__ . '/../common/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common/persistencia/Primitiva_per.php');

use serve\src\common\persistencia\Model_interfaz;

/**
 * Sistema de persistencia del Registro
 */
class Empresa_per extends \serve\src\common\persistencia\Primitiva_per {

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = ""; 
    }

   /* function setItem(Model_interfaz $Item) {
        try {
            return ( $Item->isNuevo()) ? $this->setItemInsert($Item) : $this->setItemUpdate($Item);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    function setItemInsert(Model_interfaz $Item) {
        try {
            $Sql = "INSERT INTO ".$this->Tabla." SET ".$this->PDOCampos();
            $sth = $this->Conn->prepare($Sql);
            $this->bind($sth, $Item);
            $sth->execute();
            $Item->setId($this->Conn->lastInsertId());
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    function setItemUpdate(Model_interfaz $Item) {
        try {
            $Sql = "UPDATE ".$this->Tabla." SET ".$this->PDOCampos()." WHERE Id = :ID ";
            $sth = $this->Conn->prepare($Sql);
            $sth->bindValue(':ID', $Item->getId(), \PDO::PARAM_INT);
            $this->bind($sth, $Item);
            $sth->execute();
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }*/

    private function setItemBuildSql(){
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

    
 private function setItemBuildBindParam(\PDOStatement &$sth, Model_interfaz $Item) {
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