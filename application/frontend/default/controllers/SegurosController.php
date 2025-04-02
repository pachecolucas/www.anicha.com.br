<?php

include_once 'AbstractController.php';

class SegurosController extends AbstractController {

    public function indexAction() {
        
    }

    public function verMaisAction() {
        $id = $this->getParamInt("id");
        $this->view->seguro = $this->getSeguro($id);
        if ($id === 77) { // viagem 
            $this->view->foto = "/default/images/viagem.jpg";
            $this->view->link = "https://portal.sulamericaseguros.com.br/seguroviagem.htm?ref=eyJkYWRvc1Byb2R1Y2FvIjp7IkFBIjoiNDE5OSIsIkFWIjoiMCIsIkVBIjoiMTgwODciLCJFViI6IjI2MzU5MjUiLCJ1b3BFbWlzc2FvIjoiODYiLCJ1b3BOZWdvY2lvIjoiMTYxOSJ9LCJjb3JyZXRvck5vbWUiOiJNQURSSSBTRUdVUk9TIiwiaWRDb3JyZXRvciI6IjEwMTQzOCIsInBlcmNlbnR1YWxDb3JyZXRhZ2VtIjpbeyJwZXJjZW50dWFsQ29ycmV0YWdlbSI6IjE1LjAwIn0seyJwZXJjZW50dWFsQWdlbmNpYW1lbnRvIjoiMC4wMCJ9LHsicGVyY2VudHVhbFByZXN0YWNhb1NlcnZpY28iOiIwLjAwIn0seyJpbmRleE9wY2FvIjoiNCJ9XSwibm9tZVByb21vdG9yIjoiIn0=";
        }
    }

    public function cotacaoRapidaAction() {
        try {
            $array = json_decode(file_get_contents('php://input'), true);
            //Validar e enviar contato
            $idProduto = (int) $array["produto"];
            $seguro = $this->getSeguro($idProduto);
            $email = new Email_Entity_Email_Cotacao($array, $seguro);
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
