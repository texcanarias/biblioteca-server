<?php

namespace serve\src\common\persistencia;

include_once (__DIR__ . '/../../common/persistencia/Persistencia.php');
include_once (__DIR__ . '/../../common/persistencia/Model_interfaz.php');

use serve\src\common\persistencia\Persistencia;

/**
 * Clase básica de persistencia
 *
 * @author antonio
 */
class Primitiva_per {

    /**
     * @var string La tabla donde se grabarán los datos
     */
    protected $Tabla;

    /**
     * @todo ¿está deprecated?
     * @var instancia de un objeto de tipo model 
     */
    protected $Tipos;

    /**
     * @var int conexión a la base de datos 
     */
    protected $Conn;

    function __construct() {
        $this->Conn = Persistencia::getConn();
        $this->Tabla = '';
        $this->Tipos = '';
    }

    function __destruct() {
        Persistencia::destroyConn();
    }

    /**
     * Recoge el listado de campos relacionados con el derecho o el izquierdo
     * 
     * @param $Seed Objeto que contiene los valores para hacer la busqueda del Item
     * @param $Mapper Mapeador. Relacion de las propiedades del objeto con los campos del registro
     * @param $Modelo Modelo. Objeto en el que se devuelve el resultado
     * 
     * @return Registro_model $Item Devuelve un objeto de tipo registro model.
     */
    function getItem(Model_interfaz $Seed, $Mapper, Model_interfaz $Modelo) {
        if (!is_numeric($Seed->getId())) {
            throw new \Exception("El valor de Id es incorrecto [" . $Seed->getId() . "]", 1);
        }

        if (0 >= $Seed->getId()) {
            return $Modelo;
        }

        try {
            $Sql = 'SELECT
                        *
                    FROM
                        ' . $this->Tabla . '
                    WHERE
                        Id = :Id ;';
            $sth = $this->Conn->prepare($Sql);
            $sth->bindValue(':Id', $Seed->getId(), \PDO::PARAM_INT);
            $sth->execute();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Modelo = $Mapper->mapper($row);
            }
        } catch (\PDOException $e) {
            throw $e;
        }
        return $Modelo;
    }

    /**
     * 
     * @param object $Item
     * @return boolean 
     */
    /* function esNuevo(Model_interfaz $Item) {
      $EsNuevo = (0 == $Item->getId() || -1 == $Item->getId() || null == $Item->getId()) ? TRUE : FALSE;
      return $EsNuevo;
      } */

    /**
     * Almacena en el sistema de pesistencia un objeto de tipo Registro_model
     * 
     * @param Registro_model $Item Objeto que se desea grabar
     * 
     * @return Registro_model $Item Devuelve un objeto de tipo registro model.
     */
    function setItem(Model_interfaz $Item) {
        try {
            $EsNuevo = $Item->isNuevo();
            $Sql = ($EsNuevo) ? 'INSERT INTO ' : 'UPDATE ';

            //Asignamos la tabla
            $Sql .= $this->Tabla;

            $Sql .= " SET ";

            $Sql .= ($EsNuevo) ? $this->setItemBuildSqlInsert() : $this->setItemBuidlSqlUpdate();

            //En el caso de ser un UPDATE
            $Sql .= (!$EsNuevo) ? " WHERE Id = :ID" : "";

            $sth = $this->Conn->prepare($Sql);

            ($EsNuevo) ? $this->setItemBuildBindParamInsert($sth, $Item) : $this->setItemBuildBindParamUpdate($sth, $Item);

            $sth->execute();

            //Recuperamos el Id para meter los hijos
            if ($EsNuevo) {
                $Item->setId($this->Conn->lastInsertId());
                $this->postCondicionSetItemNuevo($Item);
            }
            $this->postCondicionSetItem($Item);

            return $Item;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Aporta al SQL la relación de los campos de la base de datos con el objeto
     */
    protected function setItemBuildSql() {
        return "";
    }

    protected function setItemBuidlSqlUpdate() {
        $C = $this->setItemBuildSql();
        return $C;
    }

    protected function setItemBuildSqlInsert() {
        $C = $this->setItemBuildSql();
        return $C;
    }

    /**
     * Ejecuta las instrucciones bindParam necesarias para construir el $sth
     * 
     * @param \PDOStatement $sth
     * @param Model_interfaz $Item
     */
    protected function setItemBuildBindParam(\PDOStatement &$sth, Model_interfaz $Item) {
        
    }

    /**
     * Ejecuta las instrucciones bindParam necesarias para construir el $sth
     * 
     * @param \PDOStatement $sth
     * @param Model_interfaz $Item
     */
    protected function setItemBuildBindParamUpdate(\PDOStatement &$sth, Model_interfaz $Item) {
        $this->setItemBuildBindParam($sth, $Item);
        $sth->bindValue(':ID', $Item->getId(), \PDO::PARAM_INT);
    }

    /**
     * Ejecuta las instrucciones bindParam necesarias para construir el $sth
     * 
     * @param \PDOStatement $sth
     * @param Model_interfaz $Item
     */
    protected function setItemBuildBindParamInsert(\PDOStatement &$sth, Model_interfaz $Item) {
        $this->setItemBuildBindParam($sth, $Item);
    }

    /**
     * Instrucciones que se ejecutan despues de hacer el insert 
     * 
     * @param integer $Seed Indentificador del registro
     */
    protected function postCondicionSetItem(Model_interfaz $Seed) {
        
    }

    /**
     * Instrucciones que se ejecutan despues de hacer el insert cuando es nuevo
     * 
     * @param integer $Seed Indentificador del registro
     */
    protected function postCondicionSetItemNuevo(Model_interfaz $Seed) {
        
    }

    /**
     * Eliminamos el registro
     * 
     * @param $Seed Objeto que sirve como modelo para eliminar registro/s
     */
    public function deleteItem(Model_interfaz $Seed) {
        if ($Seed->isNuevo() || !is_numeric($Seed->getId())) {
            throw new \Exception("El valor de Id es incorrecto", 1);
        }
        $PreCondicion = $this->preCondicionDeleteItem($Seed);
        $Exito = 0;
        if ($PreCondicion) {
            try {
                $Sql = "DELETE FROM
                            " . $this->Tabla . "
                        WHERE
                            Id = :Id";
                $sth = $this->Conn->prepare($Sql);
                $sth->bindValue(':Id', $Seed->getId(), \PDO::PARAM_INT);
                $sth->execute();
                $this->postCondicionDeleteItem($Seed);
            } catch (\PDOException $e) {
                throw $e;
            }
            $Exito = 1;
        }
        return $Exito;
    }

    /**
     * Condiciones que se tienen que dar par que el registro sea eliminado
     * 
     * @param integer $Seed Identificador del registro
     * 
     * @return boolean 0 No se permite el borrado, 1 se borra
     */
    protected function preCondicionDeleteItem(Model_interfaz $Seed) {
        return 1;
    }

    /**
     * Acciones que se dan después de que el registro sea eliminado
     * 
     * @param integer $Seed Indentificador del registro
     */
    protected function postCondicionDeleteItem(Model_interfaz $Seed) {
        
    }

    /**
     * Verifica que el registro debe persistir o no. Por defecto se puede borrar.
     * @param type $Seed
     * @return boolean
     */
    public function debePersistir(Model_interfaz $Seed) {
        return !$this->preCondicionDeleteItem($Seed);
    }

}
