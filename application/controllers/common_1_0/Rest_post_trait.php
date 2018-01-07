<?php

trait Rest_post_trait {

    /**
     * Registra los datos de una area
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
            $dao = $this->getDao();
            $seed = $this->generarModeloPost($dao);
            $per = $dao->getPer();
            $PreItem = $per->setItem($seed);

            $Item = $this->accion_post($PreItem);

            $this->set_response($Item->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-1', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-2', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function accion_post($Item) {
        return $Item;
    }

}
