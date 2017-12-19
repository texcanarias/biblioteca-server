<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common/persistencia/Primitiva_listado_per.php');

include_once (__DIR__ . '/Registro_listado_mapper.php');
include_once (__DIR__ . '/Registro_mapper.php');
include_once (__DIR__ . '/Registro_model.php');

use serve\src\common\estructura\Primitiva_listado;
use serve\src\common\persistencia\Primitiva_listado_per;
use serve\src\registro_1_0\model\Registro_listado_mapper;
use serve\src\registro_1_0\model\Registro_mapper;
use serve\src\registro_1_0\model\Registro_model;

class Registro_listado_per extends Primitiva_listado_per {

    public static $NumeroIntentosLoginPermitidos = 5;
    private $TipoUsuario;

    function __construct() {
        parent::__construct();
        $this->Tabla = "ftn_reg_usuario";
        $this->TipoUsuario = -1;
    }

    function getTipoUsuario() {
        return $this->TipoUsuario;
    }

    function setTipoUsuario($TipoUsuario) {
        $this->TipoUsuario = $TipoUsuario;
        return $this;
    }

    function factoriaMappeador() {
        if (!$this->Mappeador) {
            $this->Mappeador = new Registro_listado_mapper();
        }
        return $this->Mappeador;
    }

    function getSqlItem() {
        return 'SELECT
                        ftn_reg_usuario.Id as Id,
                        ftn_reg_usuario.Nombre as Nombre,
                        ftn_reg_usuario.Apellidos as Apellidos,
                        ftn_reg_usuario.Usuario as Usuario,
                        ftn_reg_usuario.Email as EMail,
                        ftn_reg_usuario.ImagenPerfil as ImagenPerfil,
                        ftn_reg_usuario.FechaCreacion as FechaCreacion,
                        ftn_reg_usuario.FechaUltimoAcceso as FechaUltimoAcceso,
                        ftn_reg_usuario.Skin as Skin,
                        ftn_reg_usuario.IdActivo as IdActivo,
                        ftn_reg_usuario.IntentosLogin as IntentosLogin,
                        ftn_reg_usuario.IdIdioma as IdIdioma,
                        ftn_reg_tipo_usuario.Id as ftn_reg_tipo_usuario_Id,
                        ftn_reg_tipo_usuario.Nombre as NombreTipoUsuario,
                        ftn_reg_tipo_usuario.Descripcion as Descripcion,
                        ftn_reg_tipo_usuario.IdSistema as IdSistema,
                        ftn_reg_tipo_usuario.IdLibre as IdLibre,
                        ftn_reg_tipo_usuario.UrlHome as UrlHome
                    FROM
                        ftn_reg_usuario
                        LEFT JOIN
                            ftn_reg_tipo_usuario
                        ON
                            ftn_reg_usuario.ftn_reg_tipo_usuario_Id = ftn_reg_tipo_usuario.Id ';
    }

    /**
     * Crea la parte de la SQL con los datos de la busqueda
     * 
     * @param Busqueda $ClavesBusqueda Datos de la busqueda
     * 
     * @return string $Sql Parte de la SQL con los datos de la busqueda
     */
    function buildSqlBusqueda($ClavesBusqueda) {
        $SqlBusqueda = array();
        if (isset($ClavesBusqueda['buscar_por'])) {
            foreach ($ClavesBusqueda['buscar_por'] as $value) {
                if ($value == 'nombre') {
                    $SqlBusqueda[] = ' ftn_reg_usuario.Nombre LIKE "%' . $ClavesBusqueda['mandato_buscador'] . '%" ';
                }
                if ($value == 'usuario') {
                    $SqlBusqueda[] = ' ftn_reg_usuario.Usuario LIKE "%' . $ClavesBusqueda['mandato_buscador'] . '%" ';
                }
                if ($value == 'apellidos') {
                    $SqlBusqueda[] = ' ftn_reg_usuario.Apellidos LIKE "%' . $ClavesBusqueda['mandato_buscador'] . '%" ';
                }
                if ($value == 'alta') {
                    $SqlBusqueda[] = ' ftn_reg_usuario.FechaCreacion LIKE "%' . $ClavesBusqueda['mandato_buscador'] . '%" ';
                }
                if ($value == 'acceso') {
                    $SqlBusqueda[] = ' ftn_reg_usuario.FechaUltimoAcceso LIKE "%' . $ClavesBusqueda['mandato_buscador'] . '%" ';
                }
                if ($value == 'email') {
                    $SqlBusqueda[] = ' ftn_reg_usuario.EMail LIKE "%' . $ClavesBusqueda['mandato_buscador'] . '%" ';
                }
            }
        }

        if (-1 != $ClavesBusqueda['tipo']) {
            $SqlBusqueda[] = ' ftn_reg_tipo_usuario.Id = "' . $ClavesBusqueda['tipo'] . '" ';
        }
        if ((isset($ClavesBusqueda['idioma'])) && -1 != $ClavesBusqueda['idioma']) {
            $SqlBusqueda[] = ' ftn_reg_usuario.IdIdioma LIKE "%' . $ClavesBusqueda['idioma'] . '%" ';
        }
        if ((isset($ClavesBusqueda['activo'])) && -1 != $ClavesBusqueda['activo']) {
            $SqlBusqueda[] = ' ftn_reg_usuario.IdActivo = "' . $ClavesBusqueda['activo'] . '" ';
        }
        if ((isset($ClavesBusqueda['bloqueado'])) && -1 != $ClavesBusqueda['bloqueado']) {
            if (1 == $ClavesBusqueda['bloqueado']) {
                $SqlBusqueda[] = ' ftn_reg_usuario.IntentosLogin >= ' . self::$NumeroIntentosLoginPermitidos;
            }
            if (0 == $ClavesBusqueda['bloqueado']) {
                $SqlBusqueda[] = ' ftn_reg_usuario.IntentosLogin < ' . self::$NumeroIntentosLoginPermitidos;
            }
        }
        return $SqlBusqueda;
    }

    /**
     * Obtenemos los datos de todos los usuarios del sistema 
     *
     * @return Primitiva_listado $Listado Listado con los datos de los items
     */
    public function getAllItems() {
        $RegistroMapper = new Registro_mapper();
        $Listado = new Primitiva_listado();
        try {
            $Sql = $this->getSqlAllItem();
            $sth = $this->Conn->prepare($Sql)->execute();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $row['Id'] = $row['IdUsuario'];
                $row['ftn_reg_tipo_usuario_Id'] = $row['Nombre'];
                $row['Nombre'] = $row['NombreUsuario'];

                $Obj = $RegistroMapper->mapper($row);
                $Listado->add($Obj);
            }
            return $Listado;
        } catch (\PDOException $e) {
            Persistencia::VerError($e);
        }
    }

    private function getSqlAllItem() {
        return 'SELECT
                        *,
                        ftn_reg_usuario.Id as IdUsuario,
                        ftn_reg_usuario.Nombre as NombreUsuario,
                        ftn_reg_tipo_usuario.Id as IdTipoUsuario,
                        ftn_reg_tipo_usuario.Nombre as TipoUsuario,
                        ftn_reg_usuario.IdActivo as IdActivoUsuario
                    FROM
                        ftn_reg_usuario
                        LEFT JOIN
                            ftn_reg_tipo_usuario
                        ON
                            ftn_reg_usuario.ftn_reg_tipo_usuario_Id = ftn_reg_tipo_usuario.Id ';
    }

    /**
     * Recoge los datos basicos de todos los usuarios que sean administradores
     * 
     * @return array $ReMo Devuelvo un array usuarios
     * 
     * @todo Pasar a objeto listado y corregir donde se use
     */
    function getAdministradores() {
        $RegistroMapper = new Registro_mapper();
        $Listado = new Primitiva_listado();
        try {
            $sth = $this->Conn->prepare($this->getSqlAdministradores());
            $sth->execute();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Obj = $RegistroMapper->get(new Registro_model(), $row);
                $Listado->add($Obj);
            }
        } catch (\PDOException $e) {
            throw $e;
        }

        return $Listado;
    }

    private function getSqlAdministradores() {
        return 'SELECT
                        *
                    FROM
                        ftn_reg_usuario
                    WHERE
                        ftn_reg_tipo_usuario_Id = 1 ;';
    }

    /**
     * Devuelve todos los usuarios de un tipo determinado
     * 
     * @param array $IdTipoUsuario Identificador del tipo de usuario
     *
     * @return array $Listado Array con parte de los datos del objeto, no es necesario reconstruir el objeto
     */
    public function getUsuariosPorTipoUsuario($IdTipoUsuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlUsuariosPorTipoUsuario());
            $sth->bindParam(':ID_TIPO_USUARIO', $IdTipoUsuario, \PDO::PARAM_INT);
            $sth->execute();
            $Listado = array();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Listado[] = $row;
            }
            return (0 != count($Listado)) ? $Listado : 0;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlUsuariosPorTipoUsuario() {
        return 'SELECT
                        *,
                        ftn_reg_usuario.Id as IdUsuario,
                        ftn_reg_usuario.Nombre as NombreUsuario
                    FROM
                        ftn_reg_usuario
                    WHERE
                        ftn_reg_usuario.ftn_reg_tipo_usuario_Id = :ID_TIPO_USUARIO
                    ORDER BY
                        ftn_reg_usuario.Nombre;';
    }

    /**
     * Proporcina el númeto total de usuarios por tipo de usuario.
     * 
     * @return array Total de usuarios por tipo de usuario
     * 
     * @todo $Listado deberia de ser un objeto de tipo Primitiva_listado
     */
    public function getTotalPorTipoUsuario() {
        $Listado = array();
        try {
            $sth = $this->Conn->prepare($this->getSqlTotalPorTipoUsuario());
            $sth->execute();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Listado[$row['Id']] = $row['Total'];
            }

            return $Listado;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlTotalPorTipoUsuario() {
        return "SELECT
                        ftn_reg_tipo_usuario.Id as Id,
                        (SELECT 
                            count(*)
                         FROM
                            ftn_reg_usuario
                         WHERE
                            ftn_reg_usuario.ftn_reg_tipo_usuario_Id = ftn_reg_tipo_usuario.Id) as Total
                    FROM
                        ftn_reg_tipo_usuario";
    }

}
