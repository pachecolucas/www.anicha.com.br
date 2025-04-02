<?php

class Eliti_Db_Mysql extends Eliti_Db {

    private $mysqli;

    public function conectar() {
        try {
            $this->mysqli = new mysqli($this->config->getHost(), $this->config->getUser(), $this->config->getPass(), $this->config->getBase());
        } catch (Exception $e) {
            throw $e;
        }
        if ($this->mysqli->connect_errno) {
            throw new Exception("Eliti_Db_Mysql::conectar(): (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error);
        }

        $this->mysqli->set_charset("utf8");
    }

    public function executar($query, $returnArray = true) {
        
        $result = $this->mysqli->query($query);
        
        if (!$result) {
            if ($this->mysqli->errno === 1451) {
                throw new Exception("Este item não pode ser apagado pois existe(m) outro(s) que depende(m) dele.");
            }
            throw new Exception($this->mysqli->error);
        }
        
        if ($result === true) { // para o caso de INSERT ou UPDATE, por exemplo
            return true;
        }

        if ($returnArray) {
            $rows = array();
            while ($row = $result->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return $result;
        }
    }

    public function desconectar() {
        throw new Exception("Eliti_Db_Mysql::desconectar() não implementado!");
        //mysql_close();
    }

    public function getLastId() {
        return $this->mysqli->insert_id;
    }

    public function isEmpty($query) {
        $this->conectar();
        $result = $this->executar($query, false);
        return $result->num_rows === 0 ? true : false;
    }

    public function escape($string) {
        return $this->mysqli->real_escape_string($string);
    }

}
