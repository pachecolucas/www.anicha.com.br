<?php

abstract class Eliti_Controller_Crud extends Eliti_Controller_Action {
    
    protected function filtrar($where, $join) {
        $this->indexAction($where, $join);
    }

    // READ
    public function indexAction($where = null, $join = null) {
        $pagina = 1;
        if ($this->getParam("ef-pagina")) {
            $pagina = $this->getParam("ef-pagina");
        }
        $service = $this->getModel($this->getConfigModel())->getService($this->getConfigService());
        $this->view->objetos = $service->get(null, $pagina, $where, $join);
        $this->view->pagina = $pagina;
        $this->view->totalObjetos = $service->total($join);
        $this->view->totalPaginas = ceil($this->view->totalObjetos / EF_EXIBIR);
    }
    
    // CREATE AND UPDATE
    public function editarAction() {
        $service = $this->getModel($this->getConfigModel())->getService($this->getConfigService());
        $id = $this->getParam("id");
        if ($id > 0) { // edit
            $this->view->o = $service->get($id);
        } else { // create
            $this->view->o = null;
        }
        $this->onEditar($this->view->o);
    }
    
    protected function onEditar($objeto) {}


    // DELETE
    public function excluirAction() {
        try {
            $id = $this->getParam("id");
            $this->getModel($this->getConfigModel())->getService($this->getConfigService())->delete($id);
            $this->view->id = $id;
            die();
        } catch (Exception $e) {
            $this->ajaxHttpError($e->getMessage(), 501);
        }
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