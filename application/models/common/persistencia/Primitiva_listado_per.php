<?php

namespace serve\src\common\persistencia;

include_once (__DIR__ . '/Persistencia.php');
include_once (__DIR__ . '/../estructura/Primitiva_listado.php');

use serve\src\common\persistencia\Persistencia;
use serve\src\common\estructura\Primitiva_listado;

/**
 * Clase básica de persistencia
 *
 * @author antonio
 */
abstract class Primitiva_listado_per {

    /**
     * @var string La tabla donde se grabarán los datos
     */
    protected $Tabla;

    /**
     * @var instancia de un objeto de tipo model 
     */
    protected $Tipos;

    /**
     * @var int conexión a la base de datos 
     */
    protected $Conn;
    protected $Mappeador;
    protected $Busqueda;
    protected $Orden;
    protected $Paginacion;

    function __construct() {
        $this->Conn = Persistencia::getConn();
        $this->Tabla = '';
        $this->Tipos = '';
        $this->Mappeador = 0;
        $this->Busqueda = 0;
        $this->Orden = 0;
        $this->Paginacion = 0;
    }

    function __destruct() {
        Persistencia::destroyConn();
    }

    abstract function factoriaMappeador();

    function setBusqueda(Busqueda_interfaz $Busqueda) {
        $this->Busqueda = $Busqueda;
        return $this;
    }

    function setOrden(Orden_interfaz $Orden) {
        $this->Orden = $Orden;
        return $this;
    }

    function setPaginacion(Paginacion_interfaz $Paginacion) {
        $this->Paginacion = $Paginacion;
        return $this;
    }

    function getItem() {
        $Listado = new Primitiva_listado();
        try {
            $Sql = $this->getSqlItem();
            //Comprobamos si hay busqueda antes de contar el total
            $Sql .= ($this->Busqueda) ? $this->BusquedaSql($this->Busqueda) : "";

            $Listado->setTotal($this->getItemTotal($Sql));

            $Sql .= ($this->Orden) ? Persistencia::OrdenSql($this->Orden) : "";
            $Sql .= ($this->Paginacion) ? Persistencia::PaginadorSql($this->Paginacion) : "";

            $sth = $this->Conn->prepare($Sql);
            $this->getBindParam($sth);
            $sth->execute();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Listado->add($this->factoriaMappeador()->mapper($row));
            }

            return $Listado;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    protected function getItemTotal($Sql) {
        try {
            $sth = $this->Conn->prepare($Sql);
            $this->getBindParam($sth);
            $sth->execute();
            return $sth->rowCount();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    abstract function getSqlItem();

    protected function getBindParam(&$sth) {
        
    }

    protected function BusquedaSql(Busqueda_interfaz $Busqueda) {
        $Sql = '';
        $ClavesBusqueda = $Busqueda->getBusqueda();
        $TotalClavesBusqueda = count($ClavesBusqueda);
        if ($TotalClavesBusqueda > 0) {
            $SqlBusqueda = $this->buildSqlBusqueda($ClavesBusqueda);
            $Sql = Persistencia::ConstruirBusquedaSql($SqlBusqueda);
        }
        return $Sql;
    }

    protected function buildSqlBusqueda($ClavesBusqueda) {
        $SqlBusqueda = array();
        return $SqlBusqueda;
    }

    public function getTotal(Busqueda $Busqueda = null) {
        try {
            $isConBusqueda = (null == $Busqueda) ? false : true;
            $Sql = $this->getSqlItem() . ($isConBusqueda) ? $this->BusquedaSql($Busqueda) : "";
            return $this->Conn->prepare($Sql)->execute()->rowCount();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function getTotalSinFiltros() {
        try {
            return $this->getTotal();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    function getSqlItemFechaHoraCreacionActualizacion() {
        return '';
    }

    public function getFechaHoraCreacionActualizacion() {
        $Fechas = array();
        try {
            $Sql = $this->getSqlItemFechaHoraCreacionActualizacion();
            $sth = $this->Conn->prepare($Sql);
            $this->getBindParam($sth);
            $sth->execute();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Fechas = $row;
            }
            return $Fechas;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

}
