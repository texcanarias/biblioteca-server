<?php

namespace serve\src\registro_1_0\model;

include_once (__DIR__ . '/Registro_core_model.php');
include_once (__DIR__ . '/../common/time/Fecha_hora_model.php');
include_once (__DIR__ . '/../common/Object_to_array_trait.php');

use serve\src\common\time\Fecha_hora_model;

/**
 * Tiene los datos básicos de registro de cada uno de los usuarios
 * del sistema.
 */
class Registro_model extends Registro_core_model {

    use \serve\src\common\Object_to_array_trait;

    /**
     *
     * @var string Clave de usuario
     */
    protected $Pass;

    /**
     * @var fecha Fecha de alta del usuario
     */
    protected $FechaCreacion;

    /**
     * @var fecha Fecha desde que se hizo el último acceso
     */
    protected $FechaUltimoAcceso;

    /**
     * @var boolean 1 si el usuario esta activo, 0 si esta desactivado
     */
    protected $IdActivo;

    /**
     * @var int Numero de intentos de logueo del usuario
     */
    protected $IntentosLogin;

    /**
     * @var int Identificador del skin del backend
     */
    //protected $Skin;

    public function __construct() {
        parent::__construct();
        $this->IdActivo = 0;
        $this->IntentosLogin = 0;
    }

    public function getFechaCreacion() {
        return $this->FechaCreacion;
    }

    public function setFechaCreacion(Fecha_hora_model $FechaCreacion) {
        $this->FechaCreacion = $FechaCreacion;
        return $this;
    }

    public function getFechaUltimoAcceso() {
        return $this->FechaUltimoAcceso;
    }

    public function setFechaUltimoAcceso(Fecha_hora_model $FechaUltimoAcceso) {
        $this->FechaUltimoAcceso = $FechaUltimoAcceso;
        return $this;
    }

    public function getPass() {
        return $this->Pass;
    }

    public function setPass($Pass) {
        $this->Pass = $Pass;
        return $this;
    }

    public function getIdActivo() {
        return $this->IdActivo;
    }

    public function setIdActivo($IdActivo) {
        $this->IdActivo = $IdActivo;
        return $this;
    }

    public function getIntentosLogin() {
        return $this->IntentosLogin;
    }

    public function setIntentosLogin($IntentosLogin) {
        $this->IntentosLogin = $IntentosLogin;
        return $this;
    }

    /**
     * @return 1 El usuario está bloquedo 0 no lo está
     */
    public function isBloqueado() {
        return (5 <= $this->IntentosLogin) ? 1 : 0;
    }

    /**
     * Genera una cadena de carácteres aleatoria a partir de la string $CadenaSemilla y de longitud $NumeroCaracteres
     * @param int $NumeroCaracteres Número de carácteres totales
     * @param string $CadenaSemilla Cadena de carácteres
     * @todo Pasar a una clase común
     * @return string
     */
    protected function generarRandomString($NumeroCaracteres, $CadenaSemilla) {
        $total_chars = strlen($CadenaSemilla);
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= $NumeroCaracteres) {
            $num = rand() % $total_chars;
            $tmp = substr($CadenaSemilla, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    /**
     * Generar contraseña aleatoria
     *
     * @access	public
     * @param   int $NumeroCaracteres Número de carácteres que componen la clave generada
     * @todo Pasar a una clase común
     * @return	string Con una password aleatorio de 7 carácteres por defecto
     */
    public function createRandomPassword($NumeroCaracteres = 7) {
        $chars = "aAbBdDeEfFgGhHjJmMnNpPqQrRsStTuUvVwWxXyYzZ1234567890";
        return $this->generarRandomString($NumeroCaracteres, $chars);
    }

    /**
     * Generación de un usuario aleatorio
     * @todo Pasar a una clase común
     * return string Cadena con el nombre de usuario generado
     */
    public function createRandomUser() {
        $Usuario = "U";
        $charAlfabetica = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $Usuario .= $this->generarRandomString(4, $charAlfabetica);
        $charNumerica = "1234567890";
        $Usuario .= $this->generarRandomString(1, $charNumerica);
        return $Usuario;
    }

}
