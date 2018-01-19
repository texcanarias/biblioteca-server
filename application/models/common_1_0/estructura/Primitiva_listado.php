<?php

namespace serve\src\common\estructura;

/**
 * Objeto sobre el que se devuelven las consultas de getItems
 *
 * @author antonio
 */
class Primitiva_listado implements \IteratorAggregate, \Countable {

    /**
     * @var array Vector con los objetos devueltos
     */
    protected $Listado;

    /**
     * @var int Total de los registros en el sistema de persistencia
     */
    protected $Total;

    public function __construct() {
        $this->Listado = array();
        $this->Total = 0;
    }

    public function getListado() {
        return $this->Listado;
    }

    public function setListado($Listado) {
        $this->Listado = $Listado;
        return $this;
    }

    /**
     * @return int recuperamos el total de registros que hay en el sistema de persistencia
     */
    public function getTotal() {
        return $this->Total;
    }

    /**
     * @param int $Total seteamos el total de registros que hay en el sistema de persistencia
     */
    public function setTotal($Total) {
        $this->Total = $Total;
        return $this;
    }

    public function getTotalParcial() {
        return count($this->Listado);
    }

    /**
     * Implementa el método count
     * @return int
     */
    function count() {
        return count($this->Listado);
    }

    /**
     * Si no hay elementos en la consulta SIN condicionantes devuelve 1 en caso contrario 0
     * @return bool Si no hay elementos devuelve 1 en caso contrario 0;
     */
    public function isVacio() {
        return (0 == $this->Total) ? 1 : 0;
    }

    /**
     * Si no hay elementos devuelve 1 en caso contrario 0
     * @return bool Si no hay elementos devuelve 1 en caso contrario 0;
     */
    public function isVacioParcial() {
        return (0 == count($this->Listado)) ? 1 : 0;
    }

    /**
     * Se requiere la definición de la interfaz IteratorAggregate
     * @return MyIterator 
     */
    public function getIterator() {
        return new \ArrayIterator($this->Listado);
    }

    /**
     * Añadimos un elemento a la lista
     * @param type $value
     */
    public function add($Item, $Index = null) {
        if (null == $Index) {
            $this->Listado[] = $Item;
        } else {
            $this->Listado[$Index] = $Item;
        }
        return $this;
    }

    public function set($Item, $Index = null) {
        return $this->add($Item, $Index);
    }

    public function get($Index) {
        return $this->Listado[$Index];
    }

    function get_object_vars() {
        $d = $this->objectToArray($this->Listado);
        return $d;
    }

    function objectToArray($d) {
        if (is_object($d)) {
            $d = $d->get_object_vars();
        }
        if (is_array($d)) {
            return array_map(array($this, 'objectToArray'), $d);
        } else {
            return $d;
        }
    }

}
