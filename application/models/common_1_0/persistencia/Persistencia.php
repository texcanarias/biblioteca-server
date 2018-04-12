<?php
namespace serve\src\common\persistencia;

include_once (__DIR__ . '/Persistencia_primitiva.php');

use serve\src\common\persistencia\Persistencia_primitiva;

/**
 * Realiza la conexion con la base de datos.
 *
 * @author antonio.teixeira
 */
class Persistencia extends Persistencia_primitiva {

    private static $Conn = array();

    /**
     * Empleamos el patrón multiton
     * @param string $NDB Nombre de la base de datos a acceder
     * @return object $Conn Objeto de tipo PDO
     */
    public static function getConn($NDB = 'default') {
        $settings = require __DIR__ . '/../../../config/database.php';

        if (!isset(self::$Conn[$NDB])) {
            try {
                self::$Conn[$NDB] = new \PDO("mysql:host=" . $db[$NDB]['hostname'] . ";dbname=" . $db[$NDB]['database'], $db[$NDB]['username'], $db[$NDB]['password']);
                self::$Conn[$NDB]->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAME '".$db[$NDB]['char_set']."'");
                self::$Conn[$NDB]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //Activa el lanzamiento de excepciones.
                self::$Conn[$NDB]->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        return self::$Conn[$NDB];
    }

    /**
     * Destruye el objeto y desconecta la base de datos
     */
    public function __destruct() {
        
    }

    /**
     * Destruye el objeto y desconecta la base de datos
     */
    public static function destroyConn($NDB = 'default') {
        unset(self::$Conn[$NDB]);
    }

}
