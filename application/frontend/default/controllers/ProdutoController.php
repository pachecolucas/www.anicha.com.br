<?php

include_once 'AbstractController.php';

class ProdutoController extends AbstractController {

    public function exibirAction() {
        $this->_helper->layout->disableLayout();
        $id = $this->getParamInt("id");
        $this->view->produto = $this->getRemoteJson('https://meu.epanel.com.br/external/produto/' . $id)->object;
        foreach ($this->view->produto->fotos as $f) {
            $this->view->foto = $f;
            break;
        }
    }

    public function orcamentoAction() {
        try {
            $array = json_decode(file_get_contents('php://input'), true);
            //Validar e enviar contato
            $email = new Email_Entity_Email_Orcamento($array);
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
