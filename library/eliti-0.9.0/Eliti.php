<?php

class Eliti {

    public static $CHANGELOG = array(
        "06/11/2013 - v.0.4.3" => array("Nova organização de conexão com bancos de dados permite conexões com diferentes tecnologias e separa configuração (Eliti_Config_Db) da classe do banco (Eliti_Db)."),
        "30/08/2013 - v.0.4.2" => array("Correção da função delete", "Criação do método Eliti_Controller_Rest_Crud::getFilter()"),
        "29/08/2013 - v.0.4.1" => array("Incorporação do AngularJS", "Criação do epanel.js com aplicação AngularJS", "Criação do Eliti_Controller_Rest_Crud", "Criação do Eliti_Uploader e Eliti_Uploader_Image"),
        "27/07/2013 - v.0.4.0" => array("Revisão Geral", "Nova organização de pastas", "Nomes de classes mais simples e intuitivos", "Exclusão de classes desnecessárias"),
        "26/06/2013 - v.0.3.5" => array("Criado método onDelete em Eliti_Backend_Service_Crud", "Adição de um die no método excluir de Eliti_Controller_Action_Crud"),
        "13/06/2013 - v.0.3.4" => array("Correção método estático isValid da classe Eliti_Date"),
        "29/05/2013 - v.0.3.3" => array("Opção de orderBy no método filter da classe Eliti_Backend_Service_Crud"),
        "28/05/2013 - v.0.3.2" => array("Correção na contagem (total) e ordenação (defineLimit) das entidades"),
        "06/04/2013 - v.0.3.1" => array("Adição do recurso de Filtro", "Melhorias e correções CRUD", "Melhorias na view ao listar e editar entidades."),
        "05/04/2013 - v.0.3.0" => array("Aprimoramento do CRUD com as novas classes Eliti_Backend_Service_Crud e Eliti_Controller_Action_Crud"),
        "09/01/2013 - v.0.2.2" => array("Adição de funcionalidades de paginação", "Status com título, mensagem e classe personalizados", "Confirmação de exclusão de objetos da mesma página de listagem"),
        "08/01/2013 - v.0.2.1" => array("Novo formulario Ajax", "Novo método de validação com o Eliti_Backend_Exception", "Confirmação de salvamento dos objetos na mesma página da edição"),
        "07/01/2013 - v.0.2.0" => array("Incorporação do Bootstrap do Twitter"),
        "29/03/2012 - v.0.1.4" => array("Concentração de todos os arquivos públicos na pasta pública /epanel", "Module user foi excluído", "Plugin AccessController do module user foi movido para o epanel", "Controllers Login e Usuario no module epanel substituem as ações do module user"),
        "03/01/2012 - v.0.1.3" => array("Conversão dos arquivos para UTF-8"),
        "22/09/2011 - v.0.1.2" => array("Mudanças no Layout", "Inclusão de bibliotecas JQuery (UI, Makskedinput, MaskMoney, Form)"),
        "17/09/2011 - v.0.1.1" => array("Listagem, Criação, Editação e Exclusão de entidades reorganizadas em 1 Aba"),
        "29/08/2011 - v.0.1.0" => array("Primeira tentativa")
    );

    public static function print_r($a, $die = true) {
        echo "<pre>";
        print_r($a);
        echo "</pre>";
        if ($die) {
            die();
        }
    }

    public static function removeArrayKeys($original) {
        $new = array();
        foreach ($original as $o) {
            $new[] = $o;
        }
        return $new;
    }

    /*
     * Singleton
     */

    private static $_instance;

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    /**
     * @return Eliti
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) { // Testa se há instância definida na propriedade, caso sim, a classe não será instanciada novamente.
            self::$_instance = new self; // o new self cria uma instância da própria classe à própria classe.
        }
        return self::$_instance;
    }

    public function getModel($name) {
        $modelFacadeClass = $name . "_" . "Model";
        return new $modelFacadeClass;
    }

    /**
     * Retorna a sessão geral da Aplicação
     * (Vale para todos os Modelos)
     *
     * @return Zend_Session_Namespace
     */
    public function getSession() {
        return new Zend_Session_Namespace("Eliti_Session");
    }

    public function setUser(Eliti_User $user) {
        $this->getSession()->user = $user;
    }

    public function unsetUser() {
        unset($this->getSession()->user);
    }

    public function hasUser() {
        if (isset($this->getSession()->user)) {
            return true;
        }
        return false;
    }

    /**
     * @return User_Entity_Locale
     */
    public function getLocale() {
        return $this->getSession()->locale;
    }

    public function hasLocale() {
        return $this->getSession()->locale instanceof User_Entity_Locale ? true : false;
    }

    public function setLocale($locale) {
        $this->getSession()->locale = $locale instanceof User_Entity_Locale ? $locale : Eliti::getInstance()->getModel("User")->getService("Locale")->getById($locale, null);
    }

    public function clearLocale() {
        unset($this->getSession()->locale);
    }

    /**
     * Retorna o usuário registrado na sessão
     *
     * @return Eliti_User
     */
    public function getUser() {
        return $this->getSession()->user;
    }

    /**
     * Define se solicitação foi por AJAX
     */
    public static function isAjaxRequest(Zend_Controller_Request_Abstract $request) {
        /*
         * Verificação de strpos foi adicionada porque solitações ajax via $http do AngularJS não estavam sendo identificadas como AJAX.
         */
        return $request->isXmlHttpRequest() || strpos($_SERVER['HTTP_ACCEPT'], "application/json") !== false;
    }

    public function generateCode() {
        return strtoupper(substr(sha1(time() * rand(2, 100)), 0, 10));
    }

}
