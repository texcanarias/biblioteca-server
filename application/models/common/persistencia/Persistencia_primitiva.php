<?php

namespace serve\src\common\persistencia;

include_once (__DIR__ . '/../../common/persistencia/busqueda/Busqueda.php');

use serve\src\common\persistencia\busqueda\Busqueda;

/**
 * Realiza la conexion con la base de datos.
 *
 * @author antonio.teixeira
 */
class Persistencia_primitiva {

    /**
     * Contructo que crea la conexion con la base de datos.
     */
    public function __construct() {
        
    }

    /**
     * Muestra mensajes de error formateados
     * 
     * @param \PDOException $e Error
     * 
     * @return string Cadena formateada
     */
    public static function VerError(\PDOException $e) {
        return 'Error en el fichero: ' . $e->getFile() . ", linea: " . $e->getLine() . ". Mensaje: " . $e->getMessage();
    }

    /**
     * Construimos una sentencia SQL en base a los parámetros que nos llegan en el array.
     * 
     * @param array $SqlBusqueda Vector con porciones de SQL
     * @param bool $PonerCadenaWhere si se añade la cadena where o  no
     * 
     * @return string $Sql Parte de una SQL conjunta con los parámetros de búsqueda
     */
    public static function ConstruirBusquedaSql($SqlBusqueda, $PonerCadenaWhere = 1, $PonerCadenaAnd = 0) {
        $Sql = '';
        $Total = count($SqlBusqueda);
        if ($Total > 0 AND $PonerCadenaWhere) {
            $Sql = ' WHERE ';
        }
        if ($Total > 0 AND $PonerCadenaAnd) {
            $Sql = ' AND ';
        }
        for ($i = 0; $i < $Total; ++$i) {
            $Sql .= ' ' . $SqlBusqueda[$i] . ' ';
            if ($i < ($Total - 1)) {
                $Sql .= ' AND ';
            }
        }
        return $Sql;
    }

    /**
     * Creamos la parte del SQL encargada de hacer los LIMITS
     * 
     * @param Paginacion $Paginacion Datos de la paginacion
     * 
     * @return string $Sql Parte del SQL con los limits.
     */
    public static function PaginadorSql(Paginacion $Paginacion) {
        if (NULL == $Paginacion) {
            return "";
        }
        $Sql = "";
        if ("" !== (string) $Paginacion->getDesplazamiento()) {
            if (0 <= intval($Paginacion->getDesplazamiento())) {
                $Sql .= " LIMIT " . $Paginacion->getDesplazamiento();
                if (intval($Paginacion->getDocumentosPorPagina()) > 0) {
                    $Sql .= "," . $Paginacion->getDocumentosPorPagina();
                }
            }
        }
        return $Sql;
    }

    /**
     * Creamos la parte del SQL que general en orden.
     * 
     * @param Orden $Orden Instancia de tipo Orden
     * 
     * @return string $Sql Parte de la Sql encargada del orden
     */
    public static function OrdenSql(Orden $Orden) {
        $Sql = '';
        $VOrden = $Orden->getOrden();

        $IndiceOrden = $VOrden['orden'];
        $IndiceOrientacion = $VOrden['orientacion'];
        $isSePasaCampoParaOrdenar = 'nada' != $IndiceOrden;
        $isNadaEsOrdenPorDefecto = $Orden->isNadaUnCampoDeOrdenacion();
        $isOrdenar = ($isSePasaCampoParaOrdenar || $isNadaEsOrdenPorDefecto);

        if (isset($IndiceOrden)) {
            $TotalOrden = count($Orden);
            if ($TotalOrden > 0 && $isOrdenar) {
                $Campo = $Orden->getCampoSQL($IndiceOrden);
                $Sql = ' ORDER BY ' . $Campo . ' ' . $IndiceOrientacion;
            }
        }
        return $Sql;
    }

    /**
     * Creamos la parte del SQL que general la busqueda.
     * 
     * @param Busqueda $Busqueda Instancia de tipo Busqueda
     * 
     * @return string $Sql Parte de la Sql encargada del orden
     */
    public static function BusquedaSql(Busqueda $Busqueda) {
        $Sql = '';
        $ClavesBusqueda = $Busqueda->getBusqueda();
        $TotalClavesBusqueda = count($ClavesBusqueda);
        if ($TotalClavesBusqueda > 0) {
            $SqlBusqueda = array();
            foreach ($Busqueda->getParametrosBusqueda() as $Campo => $Valor) {
                if ($Valor != $ClavesBusqueda['nombre']) {
                    $SqlBusqueda[] = $Campo . ' LIKE "%' . $ClavesBusqueda['nombre'] . '%" ';
                }
            }
            $Sql = Persistencia::ConstruirBusquedaSql($SqlBusqueda);
        }
        return $Sql;
    }

    /**
     * 
     * @param type $Sth
     * @return type
     * @todo Un listado no debería devolver elementos directamente de este modo
     */
    public static function getListadoConsulta($Sth) {
        $Sth->execute();
        $Listado = array();
        while ($row = $Sth->fetch(\PDO::FETCH_ASSOC)) {
            $Listado[] = $row;
        }
        return (0 != count($Listado)) ? $Listado : 0;
    }

}
