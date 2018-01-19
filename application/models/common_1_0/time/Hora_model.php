<?php

namespace serve\src\common\time;

include_once (__DIR__ . '/Hora_interfaz.php');
include_once (__DIR__ . '/../../common/Object_to_array_trait.php');

use serve\src\common\time\Fecha_model;

/**
 * Clase de Fecha y Hora
 *
 * @author antonio
 */
class Hora_model implements Hora_interfaz {

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
        $this->Hora = $this->AjustarCadena($this->HoraDetalle) . ":" . $this->AjustarCadena($this->Minuto) . ":" . $this->AjustarCadena($this->Segundo);
    }

    private function AjustarCadena($Item) {
        $Priv = (int) $Item;
        $Cero = ($Priv < 10) ? "0" : "";
        return $Cero . $Priv;
    }

    protected function descomponer() {
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
    public function mayorQue(Hora_interfaz $Fecha) {
        return ($this->getHora() > $Hora->getHora());
    }

    public function menorQue(Hora_interfaz $Hora) {
        return ($this->getHora() < $Hora->getHora());
    }

    /**
     * Señala si la fecha del objeto es igual que otra que se pasa por parámetro
     *
     * @param Fecha_model $Fecha
     */
    public function igualQue(Fecha_interfaz $Fecha) {
        return ($this->getHora() == $Fecha->getHora());
    }

    public static function factoriaHoraModel($Hora = 0) {
        $Item = new Hora_model();
        $Item->setHora($Hora);
        return $Item;
    }

    public function __toString() {
        return $this->Hora;
    }

    public function getTiempoEnSegundos() {
        return ($this->HoraDetalle * 3600) + ($this->Minuto * 60) + $this->Segundo;
    }

    public function sumarTiempo(Hora_interfaz $Tiempo) {
        $Segundos = $Tiempo->getTiempoEnSegundos();
        $NuevaFechaHora = date("Y-m-d H:i:s", mktime((int) $this->HoraDetalle, (int) $this->Minuto, (int) $this->Segundo + $Segundos, 1, 1, 2000));
        $Atoms = explode(" ", $NuevaFechaHora);
        $Fecha = $Atoms[0];
        $Hora = $Atoms[1];
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
        return $this->sumarTiempo($Tiempo);
    }

    private function ajustarHoraSiNoExistenSegundos($Horas) {
        $LongitudCadenaSiSoloHayHorasYMinutos = 5;
        $Horas .= ($LongitudCadenaSiSoloHayHorasYMinutos == strlen($Horas)) ? ":00" : "";
        return $Horas;
    }

    protected function changeKeys($Item) {
        $Diccionario = array("Hora" => "hora",
            "HoraDetalle" => "hora_detalle",
            "Minuto" => "minuto",
            "Segundo" => "segundo");

        $Item = $this->renombrarArray($Item, $Diccionario);
        return $Item;
    }

}
