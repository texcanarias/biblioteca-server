<?php

trait Rest_put_trait {

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
        $this->verificarPermisosAcceso();

        try {
            $dao = $this->getDao();
            $seed = $this->generarModeloPut($dao);
            $per = $dao->getPer();
            $Item = $per->setItem($seed);

            $this->accion_put($Item);

            $this->set_response($Item->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-1', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-2', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function accion_put($Item) {
        return $Item;
    }

}
