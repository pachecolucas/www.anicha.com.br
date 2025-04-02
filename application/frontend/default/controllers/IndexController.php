<?php

include_once 'AbstractController.php';

class IndexController extends AbstractController {

    public function indexAction() {
        $this->view->chamadas = array(
            "casa" => array("sm-title" => "Agora com atividades on-line", "lg-title" => "tudo no seu tempo <br>e no conforto da sua casa", "link" => ""),
            "sala" => array("sm-title" => "para te (re)conectar", "lg-title" => "Um ambiente de<br>muito carinho", "link" => ""),
        );

        $this->view->chamadas2 = array(
            array("Holopráxis", "Atividades semanais (algumas gratuitas) para estar sempre conectado.", "/template/images/img13.jpg", "/holopraxis"),
            array("Atendimentos", "Ámanae, Respiração Integrativa, Barra de Access, Reiki, Coaching de Vida...", "/template/images/img14.jpg", "/atendimento"),
            array("Pós-Graduação", "Pós-graduação em TTI, Terapias Transpessoais Integrativas.", "/template/images/img10.jpg", "/formacao/tti"),
        );
    }

    private function get3Posts() {
        $result = $this->getRemoteJson("https://meu.epanel.com.br/external/blog-post/company/5/limit/3");
        if ($result) {
            return $result->objects;
        }
        return array();
    }

    public function produtoAction() {
        $this->_helper->layout->disableLayout();
        $this->view->id = $this->getParamInt("id");
    }

    public function contatoAction() {
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
