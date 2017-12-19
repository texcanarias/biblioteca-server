<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/../common/estructura/Primitiva_listado.php');
include_once (__DIR__ . '/../common/persistencia/Primitiva_per.php');

use serve\src\common\persistencia\Model_interfaz;

/**
 * Sistema de persistencia del Registro 
 * 
 * @ integer $NumeroIntentosLoginPermitidos;
 * @throws \PDOException;
 */
class Registro_per extends \serve\src\common\persistencia\Primitiva_per {

    /**
     * @static $NumeroIntentosLoginPermitidos Numero de veces que se permite hacer login sin bloquear la cuenta
     */
    public static $NumeroIntentosLoginPermitidos = 5;

    /**
     * Constructor por defecto.
     */
    function __construct() {
        parent::__construct();
        $this->Tabla = "ftn_reg_usuario";
    }

    private function constructorModelo() {
        include_once (__DIR__ . '/Registro_model.php');
        return new Registro_model();
    }

    private function constructorMapper() {
        include_once (__DIR__ . '/Registro_mapper.php');
        return new Registro_mapper();
    }

    /**
     * Verifica que usuario y contraseña están registrados en el sistema.
     *
     * @param string $Usuario   Nombre de usuario
     * @param string $Password  Clave
     *
     * @return Registro_model 
     */
    function get($Usuario, $Password) {
        try {
            $sth = $this->Conn->prepare($this->getSqlGet());
            $sth->bindParam(':USUARIO1', $Usuario, \PDO::PARAM_STR);
            $sth->bindParam(':USUARIO2', $Usuario, \PDO::PARAM_STR);
            $sth->bindParam(':PASS', $Password, \PDO::PARAM_STR);
            $sth->bindParam(':INTENTOS_LOGIN', self::$NumeroIntentosLoginPermitidos, \PDO::PARAM_INT);
            $sth->execute();

            $Item = $this->constructorModelo();
            $Mapper = $this->constructorMapper();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Item = $Mapper->mapper($row);
            }
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlGet() {
        return "SELECT
                        ftn_reg_usuario.*
                    FROM
                        ftn_reg_usuario
                        INNER JOIN
                            ftn_reg_tipo_usuario
                        ON
                            ftn_reg_usuario.ftn_reg_tipo_usuario_Id = ftn_reg_tipo_usuario.Id
                            AND
                            ftn_reg_tipo_usuario.IdActivo = 1
                    WHERE
                            ftn_reg_usuario.IdActivo = 1
                        AND
                            ftn_reg_usuario.IntentosLogin <= :INTENTOS_LOGIN                        
                        AND
                            (
                                ftn_reg_usuario.Usuario = :USUARIO1
                                OR
                                ftn_reg_usuario.EMail = :USUARIO2
                             )
                        AND
                            ftn_reg_usuario.Pass = md5(:PASS) ";
    }

    /**
     * Devuelve un objeto con los datos de un usuario según su Nombre de usuario
     * 
     * @param string $NombreUsuario Identificador de usuario
     * 
     * @return Registro_model Devuelve un objeto de tipo registro model.
     */
    function getUsuarioPorNombre($NombreUsuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlUsuarioPorNombre());
            $sth->bindParam(':NOMBRE_USUARIO', $NombreUsuario, \PDO::PARAM_INT);
            $sth->execute();
            $Item = $this->constructorModelo();
            $Mapper = $this->constructorMapper();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Item = $Mapper->mapper($row);
            }
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlUsuarioPorNombre() {
        return 'SELECT
                        *
                    FROM
                        ftn_reg_usuario
                    WHERE
                        Usuario = :NOMBRE_USUARIO ;';
    }

    /**
     * Devuelve un objeto con los datos de un usuario según su ApiKey
     * 
     * @param string $ApiKey Numero API
     * 
     * @return Registro_model Devuelve un objeto de tipo registro model.
     */
    function getUsuarioPorApiKey($ApiKey) {
        try {
            $sth = $this->Conn->prepare($this->getSqlUsuarioPorApiKey());
            $sth->bindParam(':API_KEY', $ApiKey, \PDO::PARAM_STR);
            $sth->execute();
            $Item = $this->constructorModelo();
            $Mapper = $this->constructorMapper();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Item = $Mapper->mapper($row);
            }
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlUsuarioPorApiKey() {
        return 'SELECT
                        *
                    FROM
                        ftn_reg_usuario
                    WHERE
                        ApiKey = :API_KEY ;';
    }

    /**
     * Devuelve un objeto con los datos de un usuario según su email
     * 
     * @param string $EMail Correo electrónico del usuario a identificar
     * 
     * @return Registro_model Devuelve un objeto de tipo registro model.
     */
    function getUsuarioPorEmail($EMail) {
        try {
            $sth = $this->Conn->prepare($this->getSqlUsuarioPorEmail());
            $sth->bindParam(':EMAIL', $EMail, \PDO::PARAM_STR);
            $sth->execute();
            $Item = $this->constructorModelo();
            $Mapper = $this->constructorMapper();
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Item = $Mapper->mapper($row);
            }
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlUsuarioPorEmail() {
        return 'SELECT
                        *
                    FROM
                        ftn_reg_usuario
                    WHERE
                        EMail = :EMAIL ;';
    }

    /**
     * Almacena en el sistema de pesistencia un objeto de tipo Registro_model
     * 
     * @param serve\src\registro\model\Registro_model $Item Objeto que se desea grabar
     * 
     * @return integer $Usuario->getId() Identificador del ultimo item creado/modificado
     */
    function setItem(Model_interfaz $Item) {
        try {
            $sth = $this->Conn->prepare($this->getSqlItem($Item));

            if (!$Item->isNuevo()) {
                $sth->bindValue(':ID', $Item->getId(), \PDO::PARAM_INT);
            }
            $sth->bindValue(':USUARIO', $Item->getUsuario(), \PDO::PARAM_STR);
            $sth->bindValue(':NOMBRE', $Item->getNombre(), \PDO::PARAM_STR);
            $sth->bindValue(':APELLIDOS', $Item->getApellidos(), \PDO::PARAM_STR);
            $sth->bindValue(':EMAIL', $Item->getEMail(), \PDO::PARAM_STR);
            $sth->bindValue(':TIPO_USUARIO_ID', $Item->getftn_reg_tipo_usuario_Id(), \PDO::PARAM_INT);
            $sth->bindValue(':ACTIVOID', $Item->getIdActivo(), \PDO::PARAM_INT);
            $sth->bindValue(':ID_IDIOMA', $Item->getIdIdioma(), \PDO::PARAM_STR);
            if ($Item->tieneImagenPerfil()) {
                $sth->bindValue(':IMAGEN_PERFIL', $Item->getImagenPerfil(), \PDO::PARAM_STR);
            }
            $sth->execute();

            //Recuperamos el Id para meter los hijos
            if ($Item->isNuevo()) {
                $Item->setId($this->Conn->lastInsertId());
            }

            //Eliminamos las imagenes que sobran del FTP
            if ($Item->tieneImagenPerfil()) {
                $Errores = $this->purgarImagenesPerfil();
            }

            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlItem(Registro_model $Item) {
        $Sql = ($Item->isNuevo()) ? 'INSERT INTO ' : 'UPDATE ';

        $Sql .= '
                        ftn_reg_usuario
                    SET
                        Usuario = :USUARIO,
                        Nombre = :NOMBRE ,
                        Apellidos = :APELLIDOS,
                        EMail = :EMAIL,
                        ftn_reg_tipo_usuario_Id = :TIPO_USUARIO_ID,
                        IdActivo = :ACTIVOID,
                        IdIdioma = :ID_IDIOMA,
                        ApiKey = md5(EMail)
                    ';

        if ($Item->tieneImagenPerfil()) {
            $Sql .= ' , ImagenPerfil = :IMAGEN_PERFIL ';
        }

        if (!$Item->isNuevo()) {
            $Sql .= 'WHERE
                            Id = :ID';
        } else {
            $Sql .= ', FechaCreacion = NOW()';
        }

        return $Sql;
    }

    private function contarUsuariosDeUnTipo($TipoUsuario) {
        try {
            $sthTipoUsuario = $this->Conn->prepare($this->getSqlContarUsuariosDeUnTipo());
            $sthTipoUsuario->bindParam(':TIPO_USUARIO', $TipoUsuario, \PDO::PARAM_INT);
            $sthTipoUsuario->execute();

            $rowTipoUsuario = $sthTipoUsuario->fetch(\PDO::FETCH_ASSOC);
            return $rowTipoUsuario['Resultados'];
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    private function getSqlContarUsuariosDeUnTipo() {
        return "SELECT
                                    COUNT(Id) AS Resultados
                                FROM
                                    ftn_reg_usuario
                                WHERE
                                    ftn_reg_tipo_usuario_Id = :TIPO_USUARIO";
    }

    /**
     * Para que se pueda borrar un usuario debe asegurarse que quede al menos
     * un usuario administrador y otro root.
     * 
     * @param Registro_model $Seed Identificador del usuario
     * 
     * @return boolean $PermitirBorrado Permiso para borrado o no borrado
     */
    protected function preCondicionDeleteItem(Model_interfaz $Seed) {
        $PermitirBorrado = 1;
        try {
            $TipoUsuario = $this->getItem(new Registro_model(), new Registro_mapper(), $Seed->getId())->getftn_reg_tipo_usuario_Id();

            include_once './application/libraries/usuarios_sistema.php';
            $isRoot = (Usuarios_sistema::$UsuarioRoot == $TipoUsuario);
            $isAdmin = (Usuarios_sistema::$UsuarioAdmin == $TipoUsuario);
            if ($isRoot || $isAdmin) {
                return ($this->contarUsuariosDeUnTipo($TipoUsuario) <= 1) ? 0 : 1;
            }
        } catch (\PDOException $e) {
            throw $e;
        }
        return $PermitirBorrado;
    }

    /**
     * PostCondiciones para delete item
     * 
     * @param integer $Id Identificador del usuario
     */
    protected function postCondicionDeleteItem(Model_interfaz $Seed) {
        
    }

    /**
     * Registra la fecha y hora en la tabla de usuarios como fecha de último acceso
     * 
     * @param string $Usuario Usuario 
     */
    function setFechaUltimoAcceso($Usuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlGetFechaUltimoAcceso());
            $sth->bindParam(':Usuario', $Usuario, \PDO::PARAM_STR);
            $sth->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    function getSqlGetFechaUltimoAcceso() {
        return "UPDATE
                        ftn_reg_usuario
                    SET
                        FechaUltimoAcceso = NOW()
                    WHERE
                        Usuario = :Usuario;";
    }

    /**
     * Comprueba la existencia de un usuario en la web.
     * 
     * @param string $Usuario Nombre del usuario
     * 
     * @return bool 0 no existe 1 existe
     */
    function ExisteUsuario($Usuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlExisteUsuario());
            $sth->bindParam(':Usuario', $Usuario, \PDO::PARAM_STR);
            $sth->execute();
            while ($sth->fetch(\PDO::FETCH_ASSOC)) {
                return 1;
            }
            return 0;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlExisteUsuario() {
        return 'SELECT
                        *
                    FROM
                        ftn_reg_usuario
                    WHERE
                        Usuario = :Usuario ;';
    }

    /**
     * Devuelve el numero de veces que existe un correo
     * 
     * @param string $EMail
     * 
     * @return int Total de correos encontrados
     */
    function TotalEmail($EMail) {
        try {
            $sth = $this->Conn->prepare($this->getSqlTotalEmail());
            $sth->bindParam(':EMail', $EMail, \PDO::PARAM_STR);
            $sth->execute();

            $row = $sth->fetch(\PDO::FETCH_ASSOC);

            return $row["Total"];
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlTotalEmail() {
        return 'SELECT
                        COUNT(Id) AS Total
                    FROM
                        ftn_reg_usuario
                    WHERE
                        EMail = :EMail ;';
    }

    /**
     * Actualiza la contraseña para un usuario determinado
     * 
     * @param int $Id Identificador del usuario
     * @param string $NuevaClave Nueva clave para el usuario
     */
    function setUsuarioClave($Id, $NuevaClave) {
        try {
            $sth = $this->Conn->prepare($this->getSqlSetUsuarioClave());

            $sth->bindParam(':ID', $Id, \PDO::PARAM_INT);
            $sth->bindValue(':PASSWORD', md5($NuevaClave), \PDO::PARAM_STR);
            $sth->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlSetUsuarioClave() {
        return 'UPDATE
                        ftn_reg_usuario
                    SET
                        Pass = :PASSWORD
                    WHERE
                        Id = :ID ';
    }

    /**
     * Pone la imagen para un usuario determinado
     * 
     * @param int $Id Identificador del usuario
     * @param string $NuevaClave Nueva clave para el usuario
     */
    function setImagen($Modelo) {
        try {
            $sth = $this->Conn->prepare($this->getSetImagen());

            $sth->bindParam(':ID', $Modelo->getId(), \PDO::PARAM_INT);
            $sth->bindValue(':IMAGEN_PERFIL', $Modelo->getImagenPerfil(), \PDO::PARAM_STR);
            $sth->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSetImagen() {
        return 'UPDATE
                        ftn_reg_usuario
                    SET
                        ImagenPerfil = :IMAGEN_PERFIL
                    WHERE
                        Id = :ID ';
    }

    /**
     * Genera una nueva clave de usuario determinado
     * 
     * @param integer $Id Identificador de usuario
     * 
     * @return string $Clave Devuelve la nueva password
     */
    function NuevaClave($Id) {
        try {
            $Registro = new Registro_model();
            $Clave = $Registro->createRandomPassword();
            $this->setUsuarioClave($Id, $Clave);
            return ($Clave);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * Comprueba si el correo existe en la base de datos
     * 
     * @param string $Correo Identificador del correo
     * 
     * @return integer $sth->rowCount() Devuelve el numero de registros encontrados
     */
    function BuscarCorreo($Correo) {
        try {
            return $this->TotalEmail($Correo);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * Comprueba si el correo existe en la base de datos para un usuario concreto
     * 
     * @param integer $Id Identificador de usuario
     * @param string $Correo Identificador del correo
     * 
     * @return integer $sth->rowCount() 0 no hay otro con este email, 1 o más ya hay alguno otro. Si hay más de 1 tenemos problemas.
     */
    function isCorreoAsignado($Id, $Correo) {
        try {
            $sth = $this->Conn->prepare($this->getIsCorreoAsignado());
            $sth->bindParam(':Id', $Id, \PDO::PARAM_INT);
            $sth->bindParam(':EMail', $Correo, \PDO::PARAM_STR);
            $sth->execute();
            return ($sth->rowCount());
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getIsCorreoAsignado() {
        return 'SELECT
                        id
                    FROM
                        ftn_reg_usuario
                    WHERE
                        EMail = :EMail
                        AND
                        Id != :Id ;';
    }

    /**
     * Recupera el numero de intentos de login de un usuario
     * @param int $Id Ientificador del usuario
     */
    private function getNumeroIntentos($Id) {
        try {
            $sthSelect = $this->Conn->prepare($this->getSqlNumeroIntentos());
            $sthSelect->bindParam(':ID', $Id, \PDO::PARAM_INT);
            $sthSelect->execute();

            $rowSelect = $sthSelect->fetch(\PDO::FETCH_ASSOC);

            return ($rowSelect['IntentosLogin']);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function getSqlNumeroIntentos() {
        return 'SELECT
                        IntentosLogin
                    FROM
                        ftn_reg_usuario
                    WHERE
                        Id = :ID';
    }

    private function setNumeroIntentos($Id, $Intentos) {
        try {
            $sth = $this->Conn->prepare($this->getSqlSetNumeroIntentos());

            $sth->bindParam(':ID', $Id, \PDO::PARAM_INT);
            $sth->bindParam(':INTENTOS_LOGIN', $Intentos, \PDO::PARAM_INT);
            $sth->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function getSqlSetNumeroIntentos() {
        return 'UPDATE
                        ftn_reg_usuario
                    SET
                        IntentosLogin = :INTENTOS_LOGIN
                    WHERE
                        Id = :ID';
    }

    /**
     * Comprobamos si el usuario esta activo
     * 
     * @param string $Usuario Nombre del usuario
     * 
     * @return integer $row['Activo'] Devuelve el estado activo del usuario
     */
    function comprobarActivo($Usuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlComprobarActivo());

            $sth->bindParam(':Usuario1', $Usuario, \PDO::PARAM_INT);
            $sth->bindParam(':Usuario2', $Usuario, \PDO::PARAM_INT);
            $sth->execute();

            $row = $sth->fetch(\PDO::FETCH_ASSOC);
            return($row['Activo']);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlComprobarActivo() {
        return 'SELECT
                        IdActivo AS Activo
                    FROM
                        ftn_reg_usuario
                    WHERE
                        Usuario = :Usuario1
                        OR
                        EMail = :Usuario2 ';
    }

    /**
     * Comprobamos si el usuario esta bloqueado
     * 
     * @param string $Usuario Nombre del usuario
     * 
     * @return integer $row['Activo'] Devuelve el estado bloqueado del usuario
     */
    function comprobarBloqueado($Usuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlComprobarBloqueado());

            $sth->bindParam(':Usuario1', $Usuario, \PDO::PARAM_STR);
            $sth->bindParam(':Usuario2', $Usuario, \PDO::PARAM_STR);
            $sth->execute();

            $row = $sth->fetch(\PDO::FETCH_ASSOC);
            $isUsuarioBloqueado = ($row['IntentosLogin'] >= self::$NumeroIntentosLoginPermitidos);
            return ($isUsuarioBloqueado);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlComprobarBloqueado() {
        return 'SELECT
                        IntentosLogin AS IntentosLogin
                    FROM
                        ftn_reg_usuario
                    WHERE
                        Usuario = :Usuario1
                        OR
                        EMail = :Usuario2
                    ';
    }

    /**
     * Comprobamos si el usuario aceptó la LOPD
     * 
     * @param string $Usuario Nombre del usuario
     * 
     * @return integer 0 No lo ha aceptado 1 lo aceptó
     */
    function isAceptadoLOPD($Usuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlIsAceptadoLOPD());

            $sth->bindParam(':Usuario', $Usuario, \PDO::PARAM_STR);
            $sth->execute();

            $Aceptado = 0;
            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $Aceptado = 1;
            }

            return ($Aceptado);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlIsAceptadoLOPD() {
        return 'SELECT
                        *
                    FROM
                        ftn_reg_usuario
                    WHERE
                        Usuario = :Usuario 
                        AND
                        FechaAceptacionLOPD is NOT NULL ';
    }

    /**
     * Se registra la aceptación de las condiciones legales.
     * @param int Identificador del usuario
     */
    function aceptaLOPD($Id) {
        try {
            $sth = $this->Conn->prepare($this->getSqlAceptarLOPD());
            $sth->bindParam(':ID', $Id, \PDO::PARAM_INT);
            $sth->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlAceptarLOPD() {
        return "UPDATE
                        ftn_reg_usuario
                    SET
                        FechaAceptacionLOPD = NOW()
                    WHERE
                        Id = :ID;";
    }

    /**
     * Aumentamos en 1 la cantidad de intentos de login por parte de 1 usuario
     * 
     * @param string $Usuario Nombre del usuario
     */
    function aumentarBloqueo($Usuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlAumentarBloqueo());
            $sth->bindParam(':Usuario1', $Usuario, \PDO::PARAM_INT);
            $sth->bindParam(':Usuario2', $Usuario, \PDO::PARAM_INT);
            $sth->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlAumentarBloqueo() {
        return 'UPDATE
                        ftn_reg_usuario
                    SET
                        IntentosLogin = IntentosLogin + 1
                    WHERE
                        Usuario = :Usuario1
                        OR
                        EMail = :Usuario2
                    ';
    }

    /**
     * Desbloqueamos un usuario
     * 
     * @param int $Id Identificador del usuario que se va a desbloquear
     */
    function desbloquear($Id) {
        try {
            $sth = $this->Conn->prepare($this->getSqlDesbloquear());

            $sth->bindParam(':ID', $Id, \PDO::PARAM_INT);
            $sth->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlDesbloquear() {
        return 'UPDATE
                        ftn_reg_usuario
                    SET
                        IntentosLogin = 0
                    WHERE
                        Id = :ID';
    }

    /**
     * Busca el número de usuarios que existen con un tipo de usuario determinado y devuelve el número de estos.
     * 
     * @param integer $IdTipoUsuario Identificador de tipo de usuario
     * 
     * @return integer $row["Total"] Número de usuarios encontrados de este tipo.
     */
    public function VerificarSinUsuarios($IdTipoUsuario) {
        try {
            $sth = $this->Conn->prepare($this->getSqlVerificarSinUsuarios());
            $sth->bindParam(':IdTipoUsuario', $IdTipoUsuario, \PDO::PARAM_INT);
            $sth->execute();
            $row = $sth->fetch(\PDO::FETCH_ASSOC);

            return $row["Total"];
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    private function getSqlVerificarSinUsuarios() {
        return "SELECT
                        count(*) AS Total
                    FROM
                        ftn_reg_usuario
                    WHERE
                        ftn_reg_tipo_usuario_Id = :IdTipoUsuario ";
    }

    /**
     * Determina si existe una imagen con un nombre en concreto
     * 
     * @param string $ImagenPerfil Nombre de la imagen
     * 
     * @return int 1 => La imagen si existe, 0 => La imagen no existe
     */
    public function ExisteImagenPerfil($ImagenPerfil) {
        $existeImagenBBDD = $this->comprobarImagenPerfilBBDD($ImagenPerfil);
        $ConfiguracionXML = simplexml_load_file('application/controllers/registro/modulo.xml', NULL, LIBXML_NOCDATA);
        $existeImagenFTP = $this->comprobarImagenPerfilFTP((string) $ConfiguracionXML->url_galeria, $ImagenPerfil);

        $existeImagen = ($existeImagenBBDD && $existeImagenFTP) ? 1 : 0;
        return $existeImagen;
    }

    /**
     * Determina si existe en la BBDD una imagen con un nombre en concreto
     * 
     * @param string $ImagenPerfil Nombre de la imagen
     * 
     * @return int 1 => La imagen si existe, 0 => La imagen no existe
     * 
     * @throws \PDOException
     */
    private function comprobarImagenPerfilBBDD($ImagenPerfil) {
        try {
            $sth = $this->Conn->prepare($this->getSqlComprobarImagenPerfilBBDD());
            $sth->bindParam(':ImagenPerfil', $ImagenPerfil, \PDO::PARAM_INT);
            $sth->execute();
            $row = $sth->fetch(\PDO::FETCH_ASSOC);

            $existeImagen = ($row["Total"] > 0) ? 1 : 0;
        } catch (\PDOException $e) {
            throw $e;
        }

        return $existeImagen;
    }

    private function getSqlComprobarImagenPerfilBBDD() {
        return "SELECT
                        count(Id) AS Total
                    FROM
                        ftn_reg_usuario
                    WHERE
                        ImagenPerfil = :ImagenPerfil ";
    }

    /**
     * Determina si existe en la BBDD una imagen con un nombre en concreto
     * 
     * @param string $urlGaleriaUsuarios Ruta de la carpeta en el FTP
     * @param string $ImagenPerfil Nombre de la imagen
     * 
     * @return int 1 => La imagen si existe, 0 => La imagen no existe
     * 
     * @throws \PDOException
     */
    private function comprobarImagenPerfilFTP($urlGaleriaUsuarios, $ImagenPerfil) {
        $existeImagen = (count(glob($urlGaleriaUsuarios . "/" . $ImagenPerfil))) ? 1 : 0;
        return $existeImagen;
    }

    /**
     * Eliminamso las imagnes del FTP que no  esten asociadas a ningun usuario
     * 
     * @return array Listado con los archivos que no se han podido borrar
     */
    public function purgarImagenesPerfil() {
        try {
            $ListadoBBDD = $this->getTodasImagenesPerfilBBDD();
            $ListadoFTP = $this->getTodasImagenesPerfilArchivos();

            $FicherosABorrar = array_diff($ListadoFTP, $ListadoBBDD);

            $Errores = $this->eliminarFicherosNoRelacionadosConImagenesPerfil($FicherosABorrar);

            return $Errores;
        } catch (\PDOException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function getTodasImagenesPerfilBBDD() {
        $ListadoBBDD = array();
        try {
            $sth = $this->Conn->prepare($this->getSqlPurgarImagenesPerfil());
            $sth->execute();

            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $ListadoBBDD[] = $row['ImagenPerfil'];
            }
        } catch (\PDOException $e) {
            throw $e;
        }
        return $ListadoBBDD;
    }

    private function getSqlPurgarImagenesPerfil() {
        return "SELECT
                        ImagenPerfil
                    FROM
                        ftn_reg_usuario
                    WHERE
                        ImagenPerfil IS NOT NULL ";
    }

    private function getFunctionGetDirectorioImagenes() {
        $ConfiguracionXML = simplexml_load_file('application/controllers/registro/modulo.xml', NULL, LIBXML_NOCDATA);
        $DirectorioImagenes = (string) $ConfiguracionXML->url_galeria;
        return $DirectorioImagenes;
    }

    private function getTodasImagenesPerfilArchivos() {
        $ListadoFTP = array();
        $DirectorioImagenesPerfil = opendir($this->getFunctionGetDirectorioImagenes());
        while ($Archivo = readdir($DirectorioImagenesPerfil)) {
            if (!is_dir($Archivo)) {
                $ListadoFTP[] = $Archivo;
            }
        }
        return $ListadoFTP;
    }

    private function eliminarFicherosNoRelacionadosConImagenesPerfil($ImagenesABorrar) {
        $ErroresBorrado = array();
        foreach ($ImagenesABorrar as $value) {
            try {
                $ErroresBorrado[$value] = unlink($this->getFunctionGetDirectorioImagenes() . "/" . $value) . "<br />";
            } catch (Exception $e) {
                throw $e;
            }
        }

        $Errores = array();
        foreach ($ErroresBorrado as $key => $value) {
            if ($value != 1) {
                $Errores[] = "El archivo $key no se ha borrado.";
            }
        }

        return $Errores;
    }

}
