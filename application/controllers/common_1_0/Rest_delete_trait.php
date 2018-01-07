<?php

trait Rest_delete_trait {

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
        $this->verificarPermisosAcceso();

        try {
            foreach ($this->delete() as $key => $value) {
                $Valor = json_decode($key);
                $this->accion_delete($Valor);
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

    protected function accion_delete($Valor) {
        $Id = $Valor->id;
        $this->getDao()->delete($Id);
    }

}
