<?php

abstract class Eliti_Response {

    const TYPE_SUCCESS = "SUCCESS";
    const TYPE_ERROR = "ERROR";

    public $classe;
    public $type;

    public function __construct() {
        $this->classe = get_class($this);
    }

    public function toJSON() {
        return json_encode($this);
    }

    public function send($callback = false) {
        header("HTTP/1.0 200");
        $callback ? header('Content-Type: application/json') : null;
        echo $callback ? '/**/' . $callback . '(' . $this->prepareJsonResult($this) . ')' : $this->prepareJsonResult($this);
        exit();
    }

    public function ajaxHttpError($mensage, $status = null) {
        $status = $status > 1 ? "$status" : "500";
        header("HTTP/1.0 $status");
        echo $mensage;
        exit();
    }

    public function ajaxHttpSuccess($mensage) {
        header("HTTP/1.0 200");
        echo $mensage;
        exit();
    }

    public function prepareJsonResult($value) {
        // Tira a indexação pelo id para preservar a ordem do array quando converter para json
        $value = is_array($value) ? array_values($value) : $value;
        return json_encode($value, true);
    }

}
