<?php

namespace serve\src\common\time;

include_once (__DIR__ . '/Fecha_interfaz.php');

/**
 * Clase de Fecha y Hora
 *
 * @author antonio
 */
interface Fecha_hora_interfaz extends Fecha_interfaz {

    public function getHora();

    public function setHora($Hora);

    public function getHoraDetalle();

    public function getMinuto();

    public function getSegundo();

    public function setHoraDetalle($HoraDetalle);

    public function setMinuto($Minuto);

    public function setSegundo($Segundo);

    public function getFechaHoraLinux();

    public static function factoriaFechaHoraModel($Fecha, $Hora = 0);

    public function getTiempoEnSegundos();

    public function sumarTiempo(Fecha_hora_interfaz $Tiempo);

    public function sumarHoras($Horas);
}
