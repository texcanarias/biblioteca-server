<?php

namespace serve\src\common\time;

/**
 * Interfaz de hora (tiempo)
 *
 * @author antonio
 */
interface Hora_interfaz {

    public function getHora();

    public function setHora($Hora);

    public function getHoraDetalle();

    public function getMinuto();

    public function getSegundo();

    public function setHoraDetalle($HoraDetalle);

    public function setMinuto($Minuto);

    public function setSegundo($Segundo);

    public static function factoriaHoraModel($Hora);

    public function getTiempoEnSegundos();

    public function sumarTiempo(Hora_interfaz $Tiempo);

    public function sumarHoras($Horas);
}
