<?php

namespace serve\src\common\time;

/**
 * interface fecha
 */
interface Fecha_interfaz {

    public function getFecha();

    public function setFecha($Fecha);

    public function getDia();

    public function getMes();

    public function getAnyo();

    public function setDia($Dia);

    public function setMes($Mes);

    public function setAnyo($Anyo);

    /**
     * Señala si la fecha del objeto es mayor que otra que se pasa por 
     * parámetro
     *
     * @param Fecha_interfaz $Fecha
     */
    public function mayorQue(Fecha_interfaz $Fecha);

    public function menorQue(Fecha_interfaz $Fecha);

    /**
     * Señala si la fecha del objeto es igual que otra que se pasa por parámetro
     *
     * @param Fecha_interfaz $Fecha
     */
    public function igualQue(Fecha_interfaz $Fecha);

    public function getFechaLinux();

    public static function factoriaFechaModel($Fecha = "");

    public static function factoriaFechaModelPorElementos($Anyo, $Mes, $Dia);

    public function __toString();

    public function isFinDeSemana();

    public function truncarInicioMes();

    public function truncarFinMes();

    /**
     * Método que suma días a la fecha actual.
     * @param int $Dias Número de dias a incrementar, por defecto 1
     */
    public function sumarDias($Dias = 1);

    public function desplazarPrincipiosSemana();

    public function desplazarFinalesSemana();

    public function getNumeroSemana();

    public function getNumeroUltimaSemanaAnyo();

    public function getCardinalSemanaDomingoMarca7();

    public function isLunes();

    public function isDomingo();

    public function isFinSemana();

    public function getFechaLinuxParametrizado($Fecha);
}
