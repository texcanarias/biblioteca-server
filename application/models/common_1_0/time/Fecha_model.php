<?php

namespace serve\src\common\time;

include_once (__DIR__ . '/Fecha_interfaz.php');
include_once (__DIR__ . '/../../common_1_0/Object_to_array_trait.php');

/**
 * Clase fecha
 */
class Fecha_model implements Fecha_interfaz {

    use \serve\src\common\object_to_array_trait;

    /**
     * @var string Fecha en formato Y-m-d
     */
    protected $Fecha;
    protected $Dia;
    protected $Mes;
    protected $Anyo;
    protected static $PosicionAnyo = 0;
    protected static $PosicionMes = 1;
    protected static $PosicionDia = 2;

    public function __construct() {
        $this->Fecha = date("Y-m-d");
        $this->descomponer();
    }

    public function getFecha() {
        return $this->Fecha;
    }

    public function setFecha($Fecha) {
        $this->Fecha = $Fecha;
        $this->descomponer();
        return $this;
    }

    protected function componer() {
        $this->Fecha = $this->Anyo . "-" . $this->Mes . "-" . $this->Dia;
    }

    protected function descomponer() {
        $Fecha = explode(" ", $this->Fecha);
        $Atoms = explode("-", $Fecha[0]);
        if (3 != count($Atoms)) {
            $this->Fecha = date("Y-m-d");
            $this->descomponer();
        } else {
            $this->Dia = $Atoms[self::$PosicionDia];
            $this->Mes = $Atoms[self::$PosicionMes];
            $this->Anyo = $Atoms[self::$PosicionAnyo];
        }
    }

    public function getDia() {
        return $this->Dia;
    }

    public function getMes() {
        return $this->Mes;
    }

    public function getAnyo() {
        return $this->Anyo;
    }

    public function setDia($Dia) {
        $this->Dia = $Dia;
        $this->componer();
        return $this;
    }

    public function setMes($Mes) {
        $this->Mes = $Mes;
        $this->componer();
        return $this;
    }

    public function setAnyo($Anyo) {
        $this->Anyo = $Anyo;
        $this->componer();
        return $this;
    }

    public function mayorQue(Fecha_interfaz $Fecha) {
        $TiempoLinuxObjeto = getFechaLinuxParametrizado($this->Fecha);
        $TiempoLinuxForanea = getFechaLinuxParametrizado($Fecha);
        return ($TiempoLinuxObjeto > $TiempoLinuxForanea);
    }

    public function menorQue(Fecha_interfaz $Fecha) {
        $TiempoLinuxObjeto = getFechaLinuxParametrizado($this->Fecha);
        $TiempoLinuxForanea = getFechaLinuxParametrizado($Fecha);
        return ($TiempoLinuxObjeto < $TiempoLinuxForanea);
    }

    public function igualQue(Fecha_interfaz $Fecha) {
        return ($this->Fecha == $Fecha->getFecha());
    }

    public function getFechaLinux() {
        return mktime(0, 0, 0, $this->getMes(), $this->getDia(), $this->getAnyo());
    }

    public function getFechaLinuxParametrizado($Fecha) {
        $VFecha = explode("-", $Fecha);
        return mktime(0, 0, 0, $VFecha[self::$PosicionMes], $VFecha[self::$PosicionDia], $VFecha[self::$PosicionAnyo]);
    }

    public static function factoriaFechaModel($Fecha = "") {
        $Fecha = substr($Fecha, 0, 10);
        $Item = new Fecha_model();
        if ("" != $Fecha) {
            $Item->setFecha($Fecha);
        }
        return $Item;
    }

    public static function factoriaFechaModelPorElementos($Anyo, $Mes, $Dia) {
        $Item = new Fecha_model();
        $Item->setFecha($Anyo . "-" . $Mes . "-" . $Dia);
        return $Item;
    }

    public function __toString() {
        return $this->Fecha;
    }

    public function isFinDeSemana() {
        $NumeroDiaSemana = date("w", $this->getFechaLinux());
        $isSabado = (6 == $NumeroDiaSemana);
        $isDomingo = (0 == $NumeroDiaSemana);
        $isFinDeSemana = ($isSabado || $isDomingo);
        return $isFinDeSemana;
    }

    public function truncarInicioMes() {
        $this->Dia = 1;
        $this->componer();
        return $this;
    }

    public function truncarFinMes() {
        $this->Dia = date("t", $this->getFechaLinux());
        $this->componer();
        return $this;
    }

    /**
     * Método que suma días a la fecha actual.
     * @param int $Dias Número de dias a incrementar, por defecto 1
     */
    public function sumarDias($Dias = 1) {
        $this->Fecha = date("Y-m-d", mktime(0, 0, 0, $this->Mes, $this->Dia + $Dias, $this->Anyo));
        $this->descomponer();
        return $this;
    }

    public function desplazarPrincipiosSemana() {
        $Actual = date("N", $this->getFechaLinux());
        $Objetivo = $Actual - 1;
        return $this->sumarDias(-$Objetivo);
    }

    public function desplazarFinalesSemana() {
        $Actual = date("N", $this->getFechaLinux());
        $Objetivo = 7 - $Actual;
        return $this->sumarDias($Objetivo);
    }

    public function getNumeroSemana() {
        $NumeroSemana = date("W", $this->getFechaLinux());
        return $NumeroSemana;
    }

    public function getNumeroUltimaSemanaAnyo() {
        $NumeroSemana = date("W", mktime(0, 0, 0, 12, 31, $this->Anyo));
        return $NumeroSemana;
    }

    public function getCardinalSemanaDomingoMarca7() {
        $NumeroDiaSemana = date("N", $this->getFechaLinux());
        return $NumeroDiaSemana;
    }

    public function isLunes() {
        return (1 == $this->getCardinalSemanaDomingoMarca7());
    }

    public function isDomingo() {
        return (7 == $this->getCardinalSemanaDomingoMarca7());
    }

    public function isFinSemana() {
        return (6 == $this->getCardinalSemanaDomingoMarca7() || 7 == $this->getCardinalSemanaDomingoMarca7());
    }

    protected function changeKeys($Item) {
        $Diccionario = array("Fecha" => "fecha",
            "Dia" => "dia",
            "Mes" => "mes",
            "Anyo" => "anyo");

        return $this->renombrarArray($Item, $Diccionario);
    }

}
