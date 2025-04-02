<?php

abstract class Eliti_Controller_Crud_Angular extends Eliti_Controller_Crud {
    
    public function indexAction($where = null, $join = null) {}

    public function initREST() {
        if ($this->isAjaxRequest()) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    header("Content-Type: application/json; charset=utf-8", true);
                    $this->get($this->getParamInt("id"));
                    break;
                case "POST":
                    $this->save();
                    break;
                case "PUT":
                    $this->save();
                    break;
                case "DELETE":
                    $this->delete();
                    break;
                default:
                    break;
            }
        }
    }

    // READ
    public function get($id = null) {
        $service = $this->getModel("Ramella")->getService("Video");
        if ($id) {
            $result = $this->getModel("Ramella")->getService("Video")->get($id);
        } else {
            $result = $service->get(
                    null,
                    $this->getParam("q"),
                    $this->getParam("order"),
                    $this->getParamBool("desc"), 
                    $this->getParamInt("limit"),
                    $this->getParamInt("offset"),
                    null
                );
        }
        $this->ajaxHttpSuccess(json_encode($result));
    }

    public function save() {
        $this->ajaxHttpSuccess("Chamou save()");
    }

    public function delete() {
        $this->ajaxHttpSuccess("Chamou delete()");
    }

}