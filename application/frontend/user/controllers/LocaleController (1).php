<?php

class User_LocaleController extends Eliti_Controller {

    /**
     * Alterando idioma
     */
    public function indexAction() {
        
    }
    public function changeAction() {
        try {
            $this->getModel("User")->getService("User")->changeLocale(
                        $this->getParam("idioma")
                    );
            $response = new Eliti_Response_Success_Redirect("/epanel/config/index/tab/perfil");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }
    

}