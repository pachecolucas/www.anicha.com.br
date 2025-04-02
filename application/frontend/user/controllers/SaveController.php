<?php

class User_SaveController extends Eliti_Controller {

    public function salvarAction() {
        try {
            $this->getModel("User")->getService("User")->save(
                    $this->getParamInt("id"),
                    $this->getParam("nome"),
                    $this->getParam("telefones")
                    );
//            $response = new Eliti_Response_Success_Redirect("/epanel");
            $response = new Eliti_Response_Success_Message("Salvo com sucesso");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation_Special($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }
    
}
