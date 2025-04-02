<?php

class Eliti_Exception_Key extends Eliti_Exception {

    public function addError($name, $message, $key = null) {
        $this->errors[$key][$name] = $message;
    }

}
