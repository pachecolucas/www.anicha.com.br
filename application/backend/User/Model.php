<?php

class User_Model extends Eliti_Model {
	
	public function login($email, $senha) {
		return $this->getService("Login")->login($email, $senha);
	}
	
	public function logout() {
		$this->getService("User")->logout();
	}
	
}