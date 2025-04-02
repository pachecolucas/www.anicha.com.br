<?php

class Eliti_Db_Mssql extends Eliti_Db {
    
    private function lancaExcecao($msg) {
        throw new Exception($msg);
    }

    public function conectar() {
        $result = mssql_connect($this->config->getHost(), $this->config->getUser(), $this->config->getPass());
        if (!$result) {
            $this->lancaExcecao("Eliti_Db_Mssql::conectar() Database Connection ERROR!");
        }
        mssql_select_db($this->config->getBase());
    }

    public function executar($query, $returnArray = true) {
        $result = mssql_query($query);
        
        if (!$result) {
            $mensagem = "Erro ao executar comando no banco de dados (" . mssql_get_last_message() . "). [$query]";
            throw new Exception($mensagem);
        }

        if ($result === true) // para o caso de INSERT ou UPDATE, por exemplo
            return true;

        if ($returnArray) {
            $rows = array();
            while ($row = mssql_fetch_array($result)) {
                $rows[] = $row;
            }

            return $rows;
        } else {
            return $result;
        }
    }

    public function desconectar() {
        throw new Exception("Eliti_Db_Mssql::desconectar() não implementado!");
    }

    public function getLastId() {
        throw new Exception("Eliti_Db_Mssql::getLastId() não implementado!");
    }
    
    public function isEmpty($query) {
        $result = $this->executar($query);
        return sizeof($result)?false:true;
    }

}
