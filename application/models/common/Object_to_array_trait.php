<?php

namespace serve\src\common;

/**
 * trait que provee la posibilidad del transformar los nombres de las propiedades 
 * a nombres más adecuados a un json. Así como la posiblidad de adaptar los tipos 
 * de datos del empleado por la capa de negocio a la capa de transporte (JSON).
 */
trait object_to_array_trait {

    /**
     * Para un array representativo de un objeto cambio el nombre de los indices.
     * @param array $Item
     * @param array $Diccionario
     * @return array
     */
    protected function renombrarArray($Item, $Diccionario) {
        foreach ($Diccionario as $Old => $New) {
            if (isset($Item[$Old])) {
                $Item[$New] = $Item[$Old];
                unset($Item[$Old]);
            }
        }
        return $Item;
    }

    /**
     * Cambio en el nombre de los arrays
     * @param array $Item
     * @return array
     */
    protected function changeKeys($Item) {
        return $Item;
    }

    /**
     * Convierte el objeto en un array
     * @return array
     */
    public function get_object_vars() {
        $d = get_object_vars($this);
        return $this->changeKeys($d);
    }

    /**
     * Campos que pueden ser descrito como 1 o 0 en PHP se transforman a true o false.
     * @param array $Item Vector con todos los campos
     * @param array $Campos Vector con los campos que se quieren transformar
     */
    public function adaptarBooleano($Item, $Campos) {
        foreach ($Campos as $Indice) {
            if (isset($Item[$Indice])) {
                $Item[$Indice] = $Item[$Indice] ? true : false;
            }
        }
        return $Item;
    }

    /**
     * Hay campos que pueden estar presente en la estructura del modelo pero que no son necesarios en el JSON
     * se pueden indicar y eliminar del resultado final.
     * 
     * @param array $Item Vector con todos los campos
     * @param array $Campos Vector con los campos que se quieren elimimar
     */
    public function depurarCampos($Item, $Campos) {
        foreach ($Campos as $Indice) {
            if (isset($Item[$Indice])) {
                unset($Item[$Indice]);
            }
        }
        return $Item;
    }

    /**
     * Los campos de fecha se transformaran a YYYY-mm-dd
     * 
     * @param array $Item Vector con todos los campos
     * @param array $Campos Vector con los campos que se quieren transformar
     */
    public function adaptarFecha($Item, $Campos) {
        foreach ($Campos as $Indice) {
            if (isset($Item[$Indice])) {
                $Item[$Indice] = $Item[$Indice]->__toString();
            }
        }
        return $Item;
    }

    /**
     * Los campos de tiempo se transformaran 
     * 
     * @param array $Item Vector con todos los campos
     * @param array $Campos Vector con los campos que se quieren transformar
     */
    public function adaptarTiempo($Item, $Campos) {
        return $this->adaptarFecha($Item, $Campos);
    }

}
