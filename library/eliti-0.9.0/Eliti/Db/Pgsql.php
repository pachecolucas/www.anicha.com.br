<?php

class Eliti_Db_Pgsql extends Eliti_Db {
    
    private function lancaExcecao($msg) {
        throw new Exception($msg);
    }

    public function conectar() {
        
        $connectString = "host=" . $this->config->getHost() . " port=" . $this->config->getPort() . " dbname=" . $this->config->getBase() . " user=" . $this->config->getUser() . " password=" . $this->config->getPass();

        $result = @pg_connect($connectString) or $this->lancaExcecao("Eliti_Db_Pgsql::conectar() - Não pode conectar");
        
        if (!$result) {
            $this->lancaExcecao("Eliti_Db_Pgsql::conectar() Database Connection ERROR!");
        }

        pg_query("set client_encoding to UTF8");
    }

    public function executar($query, $returnArray = true) {
        $result = pg_query($query);

        if (!$result) {
            $mensagem = "Erro ao executar comando no banco de dados (" . pg_last_error() . "). [$query]";
            throw new Exception($mensagem);
        }

        if ($result === true) // para o caso de INSERT ou UPDATE, por exemplo
            return true;

        if ($returnArray) {
            $rows = array();
            while ($row = pg_fetch_array($result)) {
                $rows[] = $row;
            }

            return $rows;
        } else {
            return $result;
        }
    }

    public function desconectar() {
        throw new Exception("Eliti_Db_Pgsql::desconectar() não implementado!");
    }

    public function getLastId() {
        throw new Exception("Eliti_Db_Pgsql::getLastId() não implementado!");
    }
    
    public function isEmpty($query) {
        throw new Exception("Eliti_Db_Pgsql->isEmpty(): Método não testado!");
        $result = $this->executar($query);
        return sizeof($result)?false:true;
    }

}
