<?php

class User_CompanyController extends Eliti_Controller {

    public function salvarAction() {
        try {
            $srvCompany = $this->getModel("User")->getService("Company");
            $srvCompany->save(
                $this->getParamInt("id"), // company
                $this->getParam("nome"),
                $this->getParam("host"),
                $this->getParam("base"),
                $this->getParam("user"),
                $this->getParam("port"),
                $this->getParam("pass")
            );
            $response = new Eliti_Response_Success_Redirect("/epanel/config/index/tab/empresas");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation_Special($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }
    
    public function setDefaultAction() {
        try {
            $idDefaultCompany = $this->getParamInt("padrao");
            $this->getModel("User")->getService("Company")->setDefault($idDefaultCompany);
            
            
            $companyName = Eliti::getInstance()->getUser()->getCompanyDefault()->nome;
            $response = new Eliti_Response_Success_Message("Empresa padrão foi definida para $companyName.");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation_Special($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }
    
    public function testarAction() {
        try {
            $er = new Eliti_Response_Error_Message("Teste de Mensagem de Erro");
            $this->ajaxHttpSuccess($er->toJSON());
            
            $srvCompany = $this->getModel("User")->getService("Company");
            $srvCompany->test(
                        $this->getParamInt("id"),
                        $this->getParam("host"),
                        $this->getParam("base"),
                        $this->getParam("user"),
                        $this->getParam("port"),
                        $this->getParam("pass")
                    );
            $this->ajaxHttpSuccess($this->prepareJsonResult(array()));
        } catch (Eliti_Exception $e) {
            $this->ajaxHttpError($e->toJson());
        } catch (Exception $e) {
            $this->ajaxHttpError($e->getMessage(), 501);
        }
    }
    
}
