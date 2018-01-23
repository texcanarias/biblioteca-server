<?php

namespace serve\src\common\time;

include_once (__DIR__ . '/Fecha_hora_interfaz.php');
include_once (__DIR__ . '/Fecha_model.php');
include_once (__DIR__ . '/../../common_1_0/Object_to_array_trait.php');

use serve\src\common\time\Fecha_model;

/**
 * Clase de Fecha y Hora
 *
 * @author antonio
 */
class Fecha_hora_model extends Fecha_model implements Fecha_hora_interfaz {

    use \serve\src\common\Object_to_array_trait;

    private static $PosicionHora = 0;
    private static $PosicionMinuto = 1;
    private static $PosicionSegundo = 2;

    /**
     * @var string Hora en formato hh:mm:ss
     */
    protected $Hora;
    protected $HoraDetalle;
    protected $Minuto;
    protected $Segundo;

    function __construct() {
        parent::__construct();
        $this->Hora = date("H:i:s");
        $this->descomponer();
    }

    public function getHora() {
        return $this->Hora;
    }

    public function setHora($Hora) {
        $this->Hora = $this->ajustarHoraSiNoExistenSegundos($Hora);
        $this->descomponer();
    }

    protected function componer() {
        parent::componer();
        $this->Hora = $this->AjustarCadena($this->HoraDetalle) . ":" . $this->AjustarCadena($this->Minuto) . ":" . $this->AjustarCadena($this->Segundo);
    }

    private function AjustarCadena($Item) {
        $Priv = (int) $Item;
        $Cero = ($Priv < 10) ? "0" : "";
        return $Cero . $Priv;
    }

    protected function descomponer() {
        parent::descomponer();
        $Atoms = explode(":", $this->Hora);
        if (3 == count($Atoms)) {
            $this->HoraDetalle = $Atoms[self::$PosicionHora];
            $this->Minuto = $Atoms[self::$PosicionMinuto];
            $this->Segundo = $Atoms[self::$PosicionSegundo];
        } else {
            $this->Segundo = 0;
            if (2 == count($Atoms)) {
                $this->HoraDetalle = $Atoms[self::$PosicionHora];
                $this->Minuto = $Atoms[self::$PosicionMinuto];
            } else {
                if (1 == count($Atoms)) {
                    $this->Minuto = 0;
                    $this->HoraDetalle = $Atoms[self::$PosicionHora];
                } else {
                    $this->HoraDetalle = 0;
                }
            }
        }
    }

    public function getHoraDetalle() {
        return $this->HoraDetalle;
    }

    public function getMinuto() {
        return $this->Minuto;
    }

    public function getSegundo() {
        return $this->Segundo;
    }

    public function setHoraDetalle($HoraDetalle) {
        $this->HoraDetalle = $HoraDetalle;
        $this->componer();
        return $this;
    }

    public function setMinuto($Minuto) {
        $this->Minuto = $Minuto;
        $this->componer();
        return $this;
    }

    public function setSegundo($Segundo) {
        $this->Segundo = $Segundo;
        $this->componer();
        return $this;
    }

    /**
     * Señala si la fecha del objeto es mayor que otra que se pasa por parámetro
     *
     * @param Fecha_model $Fecha
     */
    public function mayorQue(Fecha_interfaz $Fecha) {
        $TiempoLinuxObjeto = getFechaLinuxParametrizado($this->Fecha);
        $TiempoLinuxForanea = getFechaLinuxParametrizado($Fecha);
        return ($TiempoLinuxObjeto > $TiempoLinuxForanea);
    }

    public function menorQue(Fecha_interfaz $Fecha) {
        $TiempoLinuxObjeto = getFechaLinux();
        $TiempoLinuxForanea = getFechaLinuxParametrizado($Fecha);
        return ($TiempoLinuxObjeto < $TiempoLinuxForanea);
    }

    /**
     * Señala si la fecha del objeto es igual que otra que se pasa por parámetro
     *
     * @param Fecha_model $Fecha
     */
    public function igualQue(Fecha_interfaz $Fecha) {
        return ($this->getFecha() == $Fecha->getFecha() && $this->getHora() == $Fecha->getHora());
    }

    public function getFechaHoraLinux() {
        return $this->getFechaHoraLinuxParametrizado($this);
    }

    private function getFechaHoraLinuxParametrizado(Fecha_hora_model $Fecha) {
        $VFecha = explode("-", $Fecha->getFecha());
        $VHora = explode(":", $Fecha->getHora());
        return mktime($VHora[self::$PosicionHora], $VHora[self::$PosicionMinuto], $VHora[self::$PosicionSegundo], $VFecha[self::$PosicionMes], $VFecha[self::$PosicionDia], $VFecha[self::$PosicionAnyo]);
    }

    public static function factoriaFechaHoraModel($Fecha, $Hora = 0) {
        $Item = new Fecha_hora_model();
        if (!$Hora) {
            $PartesFechaHora = explode(" ", $Fecha);
            $Fecha = $PartesFechaHora[0];
            $Hora = (isset($PartesFechaHora[1])) ? $PartesFechaHora[1] : "00:00:00";
        }
        $Item->setFecha($Fecha);
        $Item->setHora($Hora);
        return $Item;
    }

    public function __toString() {
        return $this->Fecha . " " . $this->Hora;
    }

    public function getTiempoEnSegundos() {
        return ($this->HoraDetalle * 3600) + ($this->Minuto * 60) + $this->Segundo;
    }

    public function sumarTiempo(Fecha_hora_interfaz $Tiempo) {
        $Segundos = $Tiempo->getTiempoEnSegundos();
        $NuevaFechaHora = date("Y-m-d H:i:s", mktime((int) $this->HoraDetalle, (int) $this->Minuto, (int) $this->Segundo + $Segundos, (int) $this->Mes, (int) $this->Dia, (int) $this->Anyo));
        $Atoms = explode(" ", $NuevaFechaHora);
        $Fecha = $Atoms[0];
        $Hora = $Atoms[1];
        $this->setFecha($Fecha);
        $this->setHora($Hora);
        return $this;
    }

    public function sumarHoras($Horas) {
        $Horas = $this->ajustarHoraSiNoExistenSegundos($Horas);
        $Tiempo = new Fecha_hora_model();
        $Atoms = explode(":", $Horas);
        $Tiempo->setHoraDetalle($Atoms[self::$PosicionHora]);
        $Tiempo->setMinuto($Atoms[self::$PosicionMinuto]);
        $Tiempo->setSegundo($Atoms[self::$PosicionSegundo]);
        $Tiempo->setFecha('00-00-00');
        return $this->sumarTiempo($Tiempo);
    }

    private function ajustarHoraSiNoExistenSegundos($Horas) {
        $LongitudCadenaSiSoloHayHorasYMinutos = 5;
        $Horas .= ($LongitudCadenaSiSoloHayHorasYMinutos == strlen($Horas)) ? ":00" : "";
        return $Horas;
    }

    protected function changeKeys($Item) {
        $Diccionario = array("Fecha" => "fecha",
            "Dia" => "dia",
            "Mes" => "mes",
            "Anyo" => "anyo",
            "Hora" => "hora",
            "HoraDetalle" => "hora_detalle",
            "Minuto" => "minuto",
            "Segundo" => "segundo");

        return $this->renombrarArray($Item, $Diccionario);
    }

}
