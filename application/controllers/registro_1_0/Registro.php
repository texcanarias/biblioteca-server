<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__ . '/../euskalit_common_1_0/Euskalit.php';
include_once __DIR__ . '/../../models/common/Niveles_acceso.php';

class Registro extends Euskalit {

    function __construct() {
        parent::__construct();
    }

    protected function condicionAcceso() {
        return $this->isAdministrador;
    }

    protected function getDao() {
        include_once __DIR__ . '/../../models/registro_1_0/Registro_dao.php';
        return new serve\src\registro_1_0\model\Registro_dao();
    }

    /**
     * Devuelve la apikey con datos básicos que identifican al usuario.
     * En el caso de no existir genera un mensaje de error.
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_BAD_REQUEST            400 code 1 -> Usuario o password incorrecto
     *  
     */
    public function login_post() {
        $Usuario = $this->post("usuario");
        $Password = $this->post("pass");

        $dao = $this->getDao();
        $per = $dao->getPer();

        try {
            $ObjUsuario = $per->get($Usuario, $Password);

            if (!$ObjUsuario->isNuevo()) {
                $per->desbloquear($ObjUsuario->getId());
                $Items = array('id' => $ObjUsuario->getId(),
                    'usuario' => $ObjUsuario->getUsuario(),
                    'nombre' => $ObjUsuario->getNombre(),
                    'tipo' => $ObjUsuario->getFtn_reg_tipo_usuario_Id(),
                    'email' => $ObjUsuario->getEMail(),
                    'apikey' => $ObjUsuario->getApiKey());
                $this->set_response($Items, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $per->aumentarBloqueo($Usuario);
                $data = array('code' => '1', 'error' => 'Incorrect user or password', 'description' => 'User or password is incorrect');
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
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
     * Generar una nueva clave para un email.
     * Como respuesta se enviará un email con los datos de la nueva contraseña
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_INTERNAL_SERVER_ERROR  500 code 1 -> SMTP Error
     *  HTTP_BAD_REQUEST            400 code 1 -> No hay usuario con este email registrados
     *  
     */
    public function recuperar_post() {
        include_once __DIR__ . '/../../common/phpmailer/PhpMailer.php';

        $Email = $this->post("email");

        $dao = $this->getDao();
        $per = $dao->getPer();


        try {
            $Usuario = $per->getUsuarioPorEmail($Email);

            if (!$Usuario->isNuevo()) {
                $NuevaClave = $per->NuevaClave($Usuario->getId());

                $item = array("Nombre" => $Usuario->getApellidosNombre(),
                    "URL" => "",
                    "Usuario" => $Usuario->getUsuario(),
                    "Password" => $NuevaClave);

                $mail = \serve\src\common\phpmailer\PhpMailer::factoryPHPMailer();
                $mail->addAddress($Email);
                $mail->AddEmbeddedImage(__DIR__ . "/../../views/common/email/logo_email.png", "logo-email", "logo_email.png");
                $mail->Subject = "Recuperacion de clave";
                $mail->Body = $this->load->view('registro_1_0/email/email_nuevo_pass.html.php', $item, TRUE);

                if (!$mail->send()) {
                    $data = array('code' => '1', 'error' => 'SMTP Error', 'description' => 'SMTP Error ' . $mail->ErrorInfo);
                    $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                } else {
                    $data = array();
                    $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT);
                }
            } else {
                $data = array('code' => '1', 'error' => 'Incorrect email', 'description' => 'Nobody with this email');
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
            }
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-2', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-1', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Desbloquear una cuenta 
     * Como respuesta se enviará un email con los datos de la nueva contraseña
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_INTERNAL_SERVER_ERROR  500 code 1 -> SMTP Error
     *  HTTP_BAD_REQUEST            400 code 1 -> No hay usuario con este identificador
     *  
     */
    public function desbloquear_post() {
        include_once __DIR__ . '/../../common/phpmailer/PhpMailer.php';
        $ApiKey = $this->getApiKey();
        $Id = $this->post("id");

        $dao = $this->getDao();
        $per = $dao->getPer();

        try {
            $UsuarioPeticionarioWS = $per->getUsuarioPorApiKey($ApiKey);
            $TipoUsuario = $UsuarioPeticionarioWS->getFtn_reg_tipo_usuario_Id();

            if (Niveles_acceso::$usuarioAdministrador == $TipoUsuario) {
                $seed = $dao->getModel();
                $seed->setId($Id);
                $Usuario = $per->getItem($seed, $dao->getMapper(), $dao->getModel());
                $per->desbloquear($Id);

                if (!$Usuario->isNuevo()) {
                    $item = array("Nombre" => $Usuario->getApellidosNombre(),
                        "URL" => "");

                    $mail = \serve\src\common\phpmailer\PhpMailer::factoryPHPMailer();
                    $mail->addAddress($Usuario->getEmail());
                    $mail->AddEmbeddedImage(__DIR__ . "/../../views/common/email/logo_email.png", "logo-email", "logo_email.png");
                    $mail->Subject = "Desbloqueo de cuenta";
                    $mail->Body = $this->load->view('registro_1_0/email/cuenta_habilitada.html.php', $item, TRUE);

                    if (!$mail->send()) {
                        $data = array('code' => '1', 'error' => 'SMTP Error', 'description' => 'SMTP Error ' . $mail->ErrorInfo);
                        $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    } else {
                        $data = array();
                        $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT);
                    }
                } else {
                    $data = array('code' => '1', 'error' => 'Incorrect id', 'description' => 'Nobody with this id');
                    $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $data = array('code' => '1', 'error' => 'Permiso insuficientes', 'description' => 'No tiene permisos suficientes para esta acción.');
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
            }
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-2', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-1', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambiar el nombre y/o email de un usuario
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_FORBIDDEN              403 code 1 -> No tiene privilegios
     *  
     */
    public function nombre_email_patch() {
        $ApiKey = $this->getApiKey();
        $Id = $this->patch('id');
        $Nombre = $this->patch('nombre');
        $Email = $this->patch('email');

        try {
            $dao = $this->getDao();
            $per = $dao->getPer();

            $UsuarioPeticionarioWS = $per->getUsuarioPorApiKey($ApiKey);

            if ($Id == $UsuarioPeticionarioWS->getId()) {
                $Seed = $dao->getModel()->setId($Id);
                $Usuario = $per->getItem($Seed, $dao->getMapper(), $dao->getModel());
                $Usuario->setNombre($Nombre)->setEmail($Email);
                $per->setItem($Usuario);

                $this->set_response($Usuario->get_object_vars(), \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $data = array('code' => '1', 'error' => 'Permiso insuficientes', 'description' => 'No tiene permisos suficientes para esta acción.');
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
            }
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-2', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-1', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambiar el pasword de una cuenta
     * En el caso de pasar una password en blanco se genera una automáticamente.
     * 
     * Errores:
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -2 -> Error genérico indeterminado
     *  HTTP_INTERNAL_SERVER_ERROR  500 code -1 -> Error en la base de datos
     *  HTTP_FORBIDDEN              403 code 1 -> No tiene privilegios
     *  
     */
    public function pass_patch() {
        $ApiKey = $this->getApiKey();
        $Id = $this->patch('id');
        $NuevaClave = $this->patch('password');

        try {
            $dao = $this->getDao();
            $per = $dao->getPer();

            $UsuarioPeticionarioWS = $per->getUsuarioPorApiKey($ApiKey);

            $isPropietarioDelPassword = $Id == $UsuarioPeticionarioWS->getId();

            $isAdministrador = serve\src\registro_1_0\model\Niveles_acceso::$usuarioAdministrador == $UsuarioPeticionarioWS->getFtn_reg_tipo_usuario_Id();
            if ($isPropietarioDelPassword || $isAdministrador) {
                if ("" == $NuevaClave) {
                    $NuevaClave = $per->NuevaClave($Id);
                }
                $per->setUsuarioClave($Id, $NuevaClave);

                $this->set_response(null, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $data = array('code' => '1', 'error' => 'Permiso insuficientes', 'description' => 'No tiene permisos suficientes para esta acción.');
                $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_FORBIDDEN);
            }
        } catch (PDO\PDOException $e) {
            $data = array('code' => '-2', 'error' => 'Database error', 'description' => 'Error in database system');
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $data = array('code' => '-1', 'error' => 'Server error', 'description' => 'Something went wrong ' . $e->getMessage());
            $this->set_response($data, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
