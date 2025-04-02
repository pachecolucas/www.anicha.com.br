<?php

abstract class Eliti_Controller_Rest_Crud extends Eliti_Controller_Rest {

    protected $service;

    public function init() {
        parent::init();
        $this->service = $this->getModel($this->getConfigModel())->getService($this->getConfigService());
    }

    public function indexAction() {
        $this->get();
    }

    public function getAction() {
        $this->get($this->getParamInt("id"));
    }

    public function postAction() {
        $this->save();
//        die("From postAction() creating the requested article");
    }

    public function putAction() {
        $array = json_decode($this->getRequest()->getRawBody(), true);
        $this->sort($array);
    }

    public function save() {
        try {
            if ($this->getRequest() && array_key_exists(0, $this->getRequest()->getParams())) {
                /**
                 * Quando é salvo usando o $resource save do angular ElitiService
                 */
                $params = $this->getRequest()->getParams();
                $array = $params[0];
            } else {
                /**
                 * Quando usa o $http.post do angular (sem usar $resource)
                 */
                $array = json_decode(file_get_contents('php://input'), true);
            }
            $id = $this->service->save($array, $this->getFilter());
            $response = new Eliti_Response_Success_Object($this->get($id));
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }

    public function deleteAction() {
        try {
            $this->service->delete($this->getParamInt("id"), $this->getFilter());
            $response = new Eliti_Response_Success_Silence();
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }

    // READ
    protected function get($id = null) {
        if ($id) {
            // retornar apenas um
            $result = $this->getById($id);
            $this->onGetObject($result);
//            $resultJson = json_encode($result);
            $response = new Eliti_Response_Success_Object($result);
        } else {
            // Listar com base no filtro da view
            $result = $this->listEntities();
            $this->onGetObjects($result);
            $response = new Eliti_Response_Success_Objects(Eliti::removeArrayKeys($result));
        }
        $response->send();
    }

    protected function onGetObject(&$object) {
        
    }

    protected function onGetObjects(&$objects) {
        
    }

    protected function getById($id) {
        return $this->service->getById($id, $this->getFilter($id));
    }

    protected function listEntities() {
        $filter = $this->getParam("filter");
        $filter .= $filter ? " AND " : "";
        $filter .= $this->getFilter();

        $result = $this->service->get(
                null, $this->getParam("q"), $this->getParam("order"), $this->getParamBool("desc"), $this->getLimit(), // $this->getParamInt("limit"), 
                $this->getParamInt("offset"), null, $filter
        );

        return $result;
    }

    protected function getLimit() {
        return $this->getParam("id") === "all" ? false : $this->getParamInt("limit");
    }

    protected function getFilter($id = null) {
        return null;
    }

    protected function sort($sort) {
        $this->service->sort($sort);
        $r = new Eliti_Response_Success_Silence();
        $r->send();
    }

    // MÉTODOS DE APOIO CRUD FONTEND
    abstract function getConfig();

    protected function getConfigModel() {
        $config = $this->getConfig();
        return $config["MODEL"];
    }

    protected function getConfigService() {
        $config = $this->getConfig();
        return $config["SERVICE"];
    }

    protected function getConfigController() {
        $config = $this->getConfig();
        return $config["CONTROLLER"];
    }

}
