<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common/persistencia/Primitiva_per.php');

use serve\src\common\persistencia\Model_interfaz;

/**
 * Sistema de persistencia del Registro
 */
class Registro_core_per extends Primitiva_per {

    function __construct() {
        parent::__construct();
        $this->Tabla = "ftn_reg_usuarios";
    }

    function setItem(Model_interfaz $Item) {
        try {
            return (0 == $Item->getId()) ? $this->setItemInsert($Item) : $this->setItemUpdate($Item);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    function setItemInsert($Item) {
        try {
            $sth = $this->Conn->prepare($this->getSqlItemInsert());
            $this->bind($sth, $Item);
            $sth->execute();
            $Item->setId($this->Conn->lastInsertId());
            return $Item;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    private function getSqlItemInsert() {
        return "INSERT INTO
                        ftn_reg_usuarios
                    SET
                        Usuario = :USUARIO,
                        Nombre = :NOMBRE,
                        Apellidos = :APELLIDOS,
                        EMail = :EMAIL,
                        ftn_reg_tipo_usuario_Id = :TIPO_USUARIO_ID,
                        IdIdioma = :ID_IDIOMA,
                        FechaCreacion = NOW(),
                        ImagenPerfil = :IMAGEN_PERFIL";
    }

    function setItemUpdate($Item) {
        try {
            $sth = $this->Conn->prepare($this->getSqlItemUpdate());
            $sth->bindValue(':ID', $Item->getId(), PDO::PARAM_INT);
            $this->bind($sth, $Item);
            $sth->execute();
            return $Item;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    private function getSqlItemUpdate() {
        return "UPDATE
                        ftn_reg_usuarios
                    SET
                        Usuario = :USUARIO,
                        Nombre = :NOMBRE,
                        Apellidos = :APELLIDOS,
                        EMail = :EMAIL,
                        ftn_reg_tipo_usuario_Id = :TIPO_USUARIO_ID,
                        IdIdioma = :ID_IDIOMA,
                        ImagenPerfil = :IMAGEN_PERFIL
                    WHERE
                        Id = :ID ";
    }

    private function bind(&$sth, $Item) {
        $sth->bindValue(':USUARIO', $Item->getUsuario(), PDO::PARAM_STR);
        $sth->bindValue(':NOMBRE', $Item->getNombre(), PDO::PARAM_STR);
        $sth->bindValue(':APELLIDOS', $Item->getApellidos(), PDO::PARAM_STR);
        $sth->bindValue(':EMAIL', $Item->getEMail(), PDO::PARAM_STR);
        $sth->bindValue(':TIPO_USUARIO_ID', $Item->getFtn_reg_tipo_usuario_Id(), PDO::PARAM_INT);
        $sth->bindValue(':ID_IDIOMA', $Item->getIdIdioma(), PDO::PARAM_STR);
        $sth->bindValue(':IMAGEN_PERFIL', $Item->getImagenPerfil(), PDO::PARAM_STR);
    }

}
