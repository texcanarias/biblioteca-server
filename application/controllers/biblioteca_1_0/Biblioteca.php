<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__ . '/../common_1_0/Common.php';
include_once __DIR__ . '/../../models/common_1_0/Niveles_acceso.php';
include_once __DIR__ . '/../../models/biblioteca_1_0/Biblioteca_dao.php';


class Biblioteca extends Common {

    function __construct() {
        parent::__construct();
    }

    protected function condicionAcceso() {
        return $this->isAdministrador || $this->isGestor;
    }

    /**
     * Registra los datos de una empresa
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_FORBIDDEN              403 code 1 -> No tiene permisos
     *  
     */
    public function index_post() {
        $this->verificarPermisosAcceso();

        try {
            $dao = new serve\src\biblioteca_1_0\model\Biblioteca_dao();
            $seed = $this->generarModeloPost($dao);
            $per = $dao->getPer();
            $Item = $per->setItem($seed);
            $this->set_response($Item->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-1', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-2', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function generarModeloPost($dao) {
        $seed = $dao->getModel();
        $seed->setNombre($this->post("nombre"));
        $seed->setAutor($this->post("autor"));
        $seed->setPosicion($this->post("posicion"));
        $seed->setLeido($this->post("leido"));
        $seed->setOrigen($this->post("origen"));

        return $seed;
    }

    /**
     * Registra los datos de una empresa
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_FORBIDDEN              403 code 1 -> No tiene permisos
     *  
     * @todo se tendría que poner una medida de seguridad para impedir modificar los datos de una empresa a la que no se tenga acceso
     */
    public function index_put() {
        try {
            $dao = new serve\src\biblioteca_1_0\model\Biblioteca_dao();
            $seed = $this->generarModeloPut($dao);
            $per = $dao->getPer();
            $Item = $per->setItem($seed);
            $this->set_response($Item->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-1', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-2', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function generarModeloPut($dao) {
        $seed = $dao->getModel();
        $seed->setId($this->put("id"));
        $seed->setNombre($this->put("nombre"));
        $seed->setAutor($this->put("autor"));
        $seed->setPosicion($this->put("posicion"));
        $seed->setLeido($this->put("leido"));
        $seed->setOrigen($this->put("origen"));

        return $seed;
    }

    /**
     * Lista los bibliotecaes
     * 
     * @param $Id integer Identificador de la empresa
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_FORBIDDEN              403 code 1 -> No tiene permisos
     *  
     */
    public function index_get($Id = 0) {
        try {
            if (!$Id) {
                include_once __DIR__ . '/../../models/biblioteca_1_0/Biblioteca_listado_per.php';
                $per = new serve\src\biblioteca_1_0\model\Biblioteca_listado_per();
                $Item = $per->getItem();
                $this->set_response($Item->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $dao = new serve\src\biblioteca_1_0\model\Biblioteca_dao();
                $Item = $dao->get($Id);
                $this->set_response($Item->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-1', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-2', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Borrar un registro ya existente
     * 
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  
     * @todo se tendría que poner una medida de seguridad para impedir modificar los datos de una empresa a la que no se tenga acceso
     */
    public function index_delete() {
        try {
            $dao = new serve\src\biblioteca_1_0\model\Biblioteca_dao();
            foreach ($this->delete() as $key => $value) {
                $Valor = json_decode($key);
                $Id = $Valor->id;
                $dao->delete($Id);
                $this->set_response(NULL, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT);
            }
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-1', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-2', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}