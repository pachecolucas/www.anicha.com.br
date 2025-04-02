<?php

class Ambiente_Service_DashboardService extends Eliti_Service {

    public function getTotalGeral() {
        $this->db->conectar();

        $query = "
            SELECT
                (
                    SELECT COUNT(*) 
                    FROM (
                        SELECT DISTINCT c.id
                        FROM cliente AS c
                    ) AS c_ids
                ) AS clientes,
                (
                    SELECT COUNT(*) 
                    FROM (
                        SELECT DISTINCT o.id
                        FROM os AS o
                    ) AS o_ids
                ) AS os,
                (
                    SELECT COUNT(*) 
                    FROM (
                        SELECT DISTINCT o2.id
                        FROM os AS o2
                        WHERE o2.fechada <> 1
                    ) AS o2_ids
                ) AS os_aberta
                ";

//        die($query);
//        $query .= "(SELECT COUNT(*) FROM cobrancas WHERE (status = 1 || status = 4) AND vencimento <= '" . date("Y-m-d") . "' ) AS vencidas";
        $result = $this->db->executar($query);

        return new Ambiente_Entity_Dashboard_Geral($result[0]);
    }

}
