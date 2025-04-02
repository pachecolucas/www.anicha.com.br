<?php

class User_PassController extends Eliti_Controller {

    /**
     * Passo 1
     * Tela para informar nova senha
     */
    public function forgotAction() {
        $this->view->email = $this->getParam("email");
    }
    
    /**
     * Passo 2
     * Validando e-mail e enviando e-mail de recuperação de senha
     */
    public function recoveryAction() {
        try {
            $email = $this->getParam("email");
            $this->getModel("User")->getService("Pass")->sendRecoveryEmail($email);
            $response = new Eliti_Response_Success_Redirect("/user/pass/recovery-success/e/$email");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation_Special($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }
    public function recoverySuccessAction() {
        $this->view->email = $this->getParam("e");
    }
    
    /**
     * Passo 3
     * Abrindo link para recuperação de senha
     */
    public function newAction() {
        try {
            $userId = $this->getParamInt("u");
            $codigo = $this->getParam("c");
            $user = $this->getModel("User")->getService("User")->getByIdCode($userId, $codigo);
            $this->view->userId = $user->id;
            $this->view->codigo = $user->codigo;
        } catch (Exception $ex) {
            $this->view->errorMessage = $ex->getMessage();
            $this->render("new-failed");
        }
    }
    
    public function newFailedAction() {
    }
    
    /**
     * Passo 4
     * Validando nova senha e logando no sistema
     */
    public function saveAction() {
        try {
            $array = json_decode(file_get_contents('php://input'), true);
            $userId = trim(@$array["user"]);
            $codigo = trim(@$array["codigo"]);
            $pass1 = trim(@$array["pass1"]);
            $pass2 = trim(@$array["pass2"]);
            $this->getModel("User")->getService("Pass")->defineNewPass($userId, $codigo, $pass1, $pass2);
            $response = new Eliti_Response_Success_Redirect("/user/pass/save-success");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }

    /**
     * Passo 5
     * Mera formalidade
     */
    public function saveSuccessAction() {
        
    }

    /**
     * Alterando senha estando logado no sistema  
     */
    public function indexAction() {
        
    }

    public function changePassAction() {
        try {
            $this->getModel("User")->getService("Pass")->changePass(
                    $this->getParam("x"), $this->getParam("y"), $this->getParam("z")
            );
            $response = new Eliti_Response_Success_Redirect("/epanel/config/index/tab/perfil");
//            $response = new Eliti_Response_Success_Message("Salvo com sucesso");
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