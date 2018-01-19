<?php

namespace serve\src\common\persistencia;

class Id_unico_dao {

    protected $Per;
    protected $Model;
    protected $Mapper;
    protected $Root;
    protected $File;

    public function __construct() {
        $this->Per = NULL;
        $this->Model = NULL;
        $this->Mapper = NULL;

        $this->Root = "";
        $this->File = "";
    }

    public function getPer() {
        try {
            if (NULL == $this->Per) {
                include_once ($this->File . '_per.php');
                $class = $this->Root . '_per';
                return new $class;
            }
            return $this->Per;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getModel() {
        try {
            if (NULL == $this->Model) {
                include_once ($this->File . '_model.php');
                $class = $this->Root . '_model';
                return new $class;
            }
            return $this->Model;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getMapper() {
        try {
            if (NULL == $this->Mapper) {
                include_once ($this->File . '_mapper.php');
                $class = $this->Root . '_mapper';
                return new $class;
            }
            return $this->Mapper;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Recupera un modelo o crea una nuevo
     * @param int $Id
     * @return Persistencia_model_interface
     * @throws \PDOException
     */
    public function get($Id = 0) {
        if (!$Id) {
            return $this->getModel();
        }

        try {
            $Seed = $this->getModel();
            $Seed->setId($Id);
            $Per = $this->getPer();
            $Item = $Per->getItem($Seed, $this->getMapper(), $this->getModel());
            return $Item;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * Registra un modelo
     * @param $Item
     * @return type
     * @throws \PDOException
     */
    public function set($Item) {
        try {
            $Per = $this->getPer();
            return $Per->setItem($Item);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * Elimina un registro
     * @param type $Id
     * @throws \PDOException
     */
    public function delete($Id) {
        try {
            $Item = $this->get($Id);
            $Per = $this->getPer();
            $Per->deleteItem($Item);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

}
