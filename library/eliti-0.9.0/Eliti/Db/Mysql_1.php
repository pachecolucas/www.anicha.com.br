<?php

class Eliti_Db_Mysql extends Eliti_Db {
    
    public function conectar() {
        try {
            $result = mysql_connect($this->config->getHost(), $this->config->getUser(), $this->config->getPass());
        } catch (Exception $e) {
            throw $e;
        }
        if (!$result) {
            throw new Exception("Eliti_Db_Mysql::conectar() Database Connection ERROR!");
        }
        mysql_select_db($this->config->getBase()) or die("Eliti_Db_Mysql: Não foi possível conectar ao banco de dados '{$this->config->getBase()}'!");
        
        mysql_query("SET NAMES 'utf8'");
    }

    public function executar($query, $returnArray = true) {
        $result = mysql_query($query);

        if (!$result) {
            $mensagem = mysql_errno().": ".mysql_error()." <br> $query";//"Erro ao executar comando no banco de dados (" . mysql_errno() . "). []";
            if (mysql_errno() == 1451) {
                $mensagem = "Este item não pode ser apagado pois existem outros registros que dependem dele.";
            }
            throw new Exception($mensagem);
        }

        if ($result === true) // para o caso de INSERT ou UPDATE, por exemplo
            return true;

        if ($returnArray) {
            $rows = array();
            while ($row = mysql_fetch_array($result)) {
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
        return mysql_insert_id();
    }
    
    public function isEmpty($query) {
        $this->conectar();
        $result = $this->executar($query, false);
        return mysql_num_rows($result)?false:true;
    }

}
