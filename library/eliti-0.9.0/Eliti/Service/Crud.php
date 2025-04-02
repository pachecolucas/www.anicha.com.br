<?php

abstract class Eliti_Service_Crud extends Eliti_Service implements Eliti_Service_Interface {

    protected $where = null;
    protected $join = null;

    // TOTAL
    public function total() {
        $idKey = $this->getConfigTableAs() . ".id";
        $where = ($this->where) ? " AND {$this->where}" : "";
        $this->db->conectar();
        $query = "
            SELECT
                $idKey
            FROM {$this->getConfigTable()} AS {$this->getConfigTableAs()}
            {$this->join}
            WHERE 1 {$where}
            GROUP BY $idKey
            ";
//        die($query);
        $results = $this->db->executar($query, false);

        $total = $results->num_rows;
//        $total = (int) $results[0]["total"];
        return $total;
    }

    // FILTER
    public function filter($where, $join = null, $orderBy = null, $noLimit = false) {
        if ($noLimit) {
            throw new Exception("Eliti_Service_Crud->filter(): Uso do parâmetro 'noLimit' não mais permitido na versão 6");
        }
        return $this->get(
                        null, // $id = null
                        null, // $q = null
                        $orderBy, // $sort = null
                        null, // $desc = false
                        false, // $limit = true
                        null, // $offset = 0
                        $join, // $join = null
                        $where // $filter = null
        );
//          {
//        if ($noLimit) {
//            return $this->get(null, null, $where, $join, $orderBy);
//        } else {
//            return $this->get(null, null, $where, $join, $orderBy);
//        }
    }

//    protected function onGet($id, array $objetos) {}
    // DELETE
    public function delete($id, $filter) {
        $this->db->conectar();
        $id = intval($id);
        if ($id < 1)
            throw new Exception("Id inválido!");
        $p = $this->getById($id, $filter);
        if (!$p) {
            throw new Exception("Object - $id - não encontrado!");
        }
        $this->onDelete($p, $filter);
        $this->db->executar("DELETE FROM " . $this->getConfigTable() . " WHERE id = $id");
        $this->afterDelete($p, $filter);
    }

    protected function onDelete($entity, $filter) {
        
    }

    protected function afterDelete($entity, $filter) {
        
    }

    // MÉTODOS DE APOIO CRUD
    abstract function getConfig();

    abstract function getSelect();

    abstract function getSelectExtra();

    abstract function getJoin();

    abstract function getJoinExtra();

    abstract function getOrder();

    /**
     * Criada em 02/02/2015 por Lucas Pacheco
     * Este método não é abstrato para manter compatibilidade com versões anteriores do ElitiFramework
     */
    public function getOrderExtra() {
        return null;
    }

    function getWhere($id = 0, $pagina = null, $orderBy = null) {
        $WHERE = ($id) ? " WHERE " . $this->getConfigTableAs() . ".id = $id " : " WHERE 1 ";
        $WHERE .= ($pagina !== null) ? $this->defineLimit($this->getConfigTable(), $this->getConfigTableAs(), "id", $pagina, $this->where, $this->join, $orderBy) : "";
        $WHERE .= $this->where ? " AND $this->where" : "";
        return $WHERE;
    }

    protected function getConfigTable() {
        $config = $this->getConfig();
        return $config["TABLE"];
    }

    protected function getConfigTableAs() {
        $config = $this->getConfig();
        return $config["TABLE_AS"];
    }

    protected function getConfigClasse() {
        $config = $this->getConfig();
        return $config["CLASSE"];
    }

//    public static function lineToObject($linha, &$objetos) {
//        Cliente_Service_EstruturaService::lineToObject($linha, $objetos);
////        throw new Exception("Eliti_Service_Crud::lineToObject(...): Não foi sobreescrito!");
//    }

    protected function convertToOneLevelArray($values, array &$arrayResult) {
        if (is_array($values)) {
            foreach ($values as $value) {
                $this->convertToOneLevelArray($value, $arrayResult);
            }
        } else {
            $arrayResult[] = $values;
        }
    }

}
