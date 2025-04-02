<?php

abstract class Eliti_Service_Crud_Rest extends Eliti_Service_Crud {

    protected abstract function getSearchColumns();

    private function cleanGetSearchColumns() {
        $searchColums = "' ', ";
        if ($this->getSearchColumns()) {
            $searchColums .= trim($this->getSearchColumns(), ",");
        } else {
            $config = $this->getConfig();
            $searchColums .= $config["TABLE_AS"] . ".id";
        }
        return $searchColums;
    }

    /*
     * Esse método problemático é o que está mudando da versão 0.5.0 para a 0.5.1
     */

    protected function defineLimitRest($tableName, $tableNameAs, $columnBaseName, $offset, $where = "", $join = "", $orderBy = null, $WHERE_KEYWORDS = "", $limit = true, $filter = null) {
        $idKey = $tableNameAs . "." . $columnBaseName;
//        $inicio = ($pagina > 0) ? ceil(($pagina - 1) * EF_EXIBIR) : 0;
        $orderBy = $orderBy ? $orderBy : $idKey;
        $WHERE = "WHERE 1";
        $WHERE .= $where ? " AND $where " : "";
        $WHERE .= $WHERE_KEYWORDS;
        $WHERE .= $filter ? " AND " . $filter : "";
        $JOIN = $join ? $join : $this->getJoin();
//        die("LIMIT:".$limit);
        if ($limit === false) {
            $LIMIT_OFFSET = "";
        } else {
            $limit = (is_nan($limit) || !$limit) ? EF_EXIBIR : $limit;
            $LIMIT_OFFSET = ($limit !== false) ? "LIMIT " . $limit . " OFFSET $offset" : "";
        }

        $result = " AND $idKey IN (
                                    SELECT $idKey 
                                    FROM (
                                          SELECT $idKey 
                                          FROM $tableName AS $tableNameAs
                                          $JOIN
                                          $WHERE
                                          GROUP BY $idKey
                                          ORDER BY $orderBy
                                          $LIMIT_OFFSET
                                    ) AS $tableNameAs
                                )";
//        Eliti::print_r($result);
        return $result;
    }

    function getWhereRest($id = 0, $offset = 0, $orderBy = null, $WHERE_KEYWORDS, $limit = true, $filter = null) {
        $WHERE = "  WHERE 1 ";
        if ($id) {
            $filterById = $filter ? " AND $filter " : "";
            $WHERE = " WHERE " . $this->getConfigTableAs() . ".id = $id $filterById";
        } else if ($offset !== null || $limit === false || $filter !== null) {
            $WHERE .= $this->defineLimitRest($this->getConfigTable(), $this->getConfigTableAs(), "id", $offset, $this->where, $this->join, $orderBy, $WHERE_KEYWORDS, $limit, $filter);
        } else {
            $WHERE .= "";
        }
        $WHERE .= $this->where ? " AND $this->where" : "";
        return $WHERE;
    }

    // READ
    public function getAll($filter) {
        return $this->get(null, null, null, null, false, null, null, $filter);
    }

//    public function getAllByFilter($filter) {
//        return $this->get(null, null, null, null, false, null, null, $filter);
//    }

    public function getById($id, $filter) {
        return $this->get($id, null, null, null, null, null, null, $filter);
    }

    public function get($id = null, $q = null, $sort = null, $desc = false, $limit = true, $offset = 0, $join = null, $filter = null) {

//        $WHERE      = $q?" WHERE v.descricao LIKE '%$q%' ":"";
        $DESC = $desc ? " DESC " : "";
        $ORDER = $id && $this->getOrderExtra() ? $this->getOrderExtra() : $this->getOrder();
        $orderBy = $sort ? "$sort $DESC" : $ORDER;

        $this->db->conectar();

        // se tiver ID informado, então carrega o select e o join extra
        $SELECT = array();
        $this->convertToOneLevelArray($this->getSelect(), $SELECT);
        $JOIN = $this->getJoin();

        $WHERE_KEYWORDS = "";

        if ($id) {
            $this->convertToOneLevelArray($this->getSelectExtra(), $SELECT);
            $JOIN = $JOIN . " " . $this->getJoinExtra();
        } else if ($q) {
            $keywords = explode(' ', $q);
            foreach ($keywords as $keyword) {
                $WHERE_KEYWORDS .= " AND ";

                $escaped = $this->db->escape($keyword); // Solução pra Tono's Bar
                $WHERE_KEYWORDS .= " CONVERT(CONCAT_WS(" . $this->cleanGetSearchColumns() . ") USING utf8) 
                        LIKE '%$escaped%'";
            }
        }

//        die($filter);

        $query = "
                SELECT
                    " . implode(",
                    ", $SELECT) . "
                FROM " . $this->getConfigTable() . " AS " . $this->getConfigTableAs() . "
                $JOIN
                " . $this->getWhereRest($id, $offset, $orderBy, $WHERE_KEYWORDS, $limit, $filter) . "
                ORDER BY $orderBy
            ";

//        die($query);

        $result = $this->db->executar($query, false);

//        $objetos = array();
//        while ($linha = mysql_fetch_array($result)) {
//            $srvClassName = $this->getClassName();
//            $srvClassName::lineToObject($linha, $objetos);
//        }

        $objetos = $this->resultToObjects($result);

        $this->onGet($objetos);

//        Eliti::print_r($objetos);

        // id foi informado e é para retornar apenas um
        if ($id) {
            return array_shift($objetos);
        }

        // Se o id foi informado e não retornou nenhum então lança exceção
        if ($id) {
            throw new Exception("Entidade - $id - não encontrada.");
        }


        return $objetos;
    }

    protected function onGet(&$objects) {
        
    }

    protected function resultToObjects($result) {
        $objetos = array();
        if (is_bool($result)) {
            return $objetos;
        }
        while ($linha = $result->fetch_array()) {
            $srvClassName = $this->getClassName();
            $srvClassName::lineToObject($linha, $objetos);
        }
        return $objetos;
    }

    public function sort($newSort) {

        $this->db->conectar();

        $ids = implode(", ", $newSort);
        $query = "
            SELECT
                id, 
                sort,
                (SELECT MIN(sort) FROM " . $this->getConfigTable() . " WHERE id IN ($ids)) AS min
            FROM " . $this->getConfigTable() . "
            WHERE id IN ($ids)
            ORDER BY sort
            ";

        $resultOldOrder = $this->db->executar($query);
        $oldSort = array();
        $minSort = 0;
        foreach ($resultOldOrder as $r) {
            $sort = (int) $r["sort"];
            $minSort === 0 ? $minSort = $sort : null;
            $oldSort[(int) $r["id"]] = (int) $r["sort"];
        }

        foreach ($newSort as $id) {
            $this->db->executar("UPDATE " . $this->getConfigTable() . " SET sort = $minSort WHERE id = $id");
            $minSort++;
        }

    }

}
