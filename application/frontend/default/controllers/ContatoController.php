<?php

include_once 'AbstractController.php';

class ContatoController extends AbstractController {

    public function indexAction() {
        $this->view->classe = "";
    }

    public function enviarAction() {
        try {
            $array = json_decode(file_get_contents('php://input'), true);
            //Validar e enviar contato
            $email = new Email_Entity_Email_Contato($array);
            $email->send();

            //Retorna confirmação
            $r = new Eliti_Response_Success_Silence();
            $r->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }

}
