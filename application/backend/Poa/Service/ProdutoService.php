<?php

class Poa_Service_ProdutoService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "produto";
    const TABLE_AS = "produto";
    const CLASSE = "Poa_Entity_Produto";

    public static function select() {
        return array(
            self::TABLE_AS . ".id           AS " . self::TABLE_AS . "_id",
            self::TABLE_AS . ".nome         AS " . self::TABLE_AS . "_nome",
            self::TABLE_AS . ".descricao    AS " . self::TABLE_AS . "_desc",
            self::TABLE_AS . ".ordem        AS " . self::TABLE_AS . "_ordem",
//            "produto_foto.id                AS produto_foto_id",
//            "produto_foto.mini              AS produto_foto_mini",
//            "produto_foto.foto              AS produto_foto_foto",
//            "(SELECT COUNT(*) FROM produto_foto WHERE produto_foto.produto = produto.id) AS produto_numFotos",
        );
    }

    protected function getSearchColumns() {
        return self::TABLE_AS . ".nome," .
                self::TABLE_AS . ".descricao," .
                self::TABLE_AS . ".id";
    }

    public static function join() {
        return "
            ";
    }

    public static function selectExtra() { // para tabelas relacionadas
        return array(
        );
    }

    public static function joinExtra() {
        return "
            ";
    }

    public static function order() {
        return self::TABLE_AS . ".ordem," .
                self::TABLE_AS . ".id";
    }

    public static function lineToObject($linha, &$objetos) {
        if (!array_key_exists($linha[self::TABLE_AS . "_id"], $objetos)) {
            $className = self::CLASSE;
            $objetos[$linha[self::TABLE_AS . "_id"]] = new $className($linha);
        }

        $objeto = $objetos[$linha[self::TABLE_AS . "_id"]];

        // fotos
        $idFoto = array_key_exists("produto_foto_id", $linha) ? (int) $linha["produto_foto_id"] : false;
        if ($idFoto && !$objeto->hasFoto($idFoto)) {
            $objeto->addFoto(new Poa_Entity_Produto_Foto($linha));
        }
    }

    /**
     * VALIDAÇÃO E PERSISTÊNCIA
     */
    public function save($r) {
        /**
         * VALIDAÇÃO
         */
        $ee = new Eliti_Exception();

        // id
        $id = $this->getParamInt(@$r["id"]);

        // nome
        $nome = $this->getParam(@$r["nome"]);
        !$nome ? $ee->addError("produtoNome", "Informe o nome do produto") : null;

        // descricao
        $desc = $this->getParam(@$r["desc"]);
        !$desc ? $ee->addError("produtoDesc", "Descreva este produto") : null;

        // ordem
        $ordem = $this->getParamInt(@$r["ordem"]);

        // fotos
        $fotos = @$r["fotos"];
        foreach ($fotos as $f) {
            $fMini = @$f["mini"];
            $fFoto = @$f["foto"];
            !$fMini ? $ee->addError("produtoFotos", "Há foto sem miniatura.") : null;
            !$fFoto ? $ee->addError("produtoFotos", "Há foto sem arquivo.") : null;

            // verifica se existe arquivo no lugar certo para miniatura
            $fullPathMini = PUBLIC_PATH . Poa_Entity_Produto_Foto::PATH . $fMini;
            if ($fMini && !file_exists($fullPathMini)) {
                $ee->addError("produtoFotos", "Arquivo miniatura não encontrado: $fullPathMini");
            }

            // verifica se existe arquivo no lugar certo para original
            $fullPathFoto = PUBLIC_PATH . Poa_Entity_Produto_Foto::PATH . $fFoto;
            if ($fFoto && !file_exists($fullPathFoto)) {
                $ee->addError("produtoFotos", "Arquivo original não encontrado: $fullPathFoto");
            }
        }

        $ee->throwExceptionIfErrorExists();

        /**
         * SALVAR
         */
        $this->db->conectar();

        if ($id > 0) {
            $query = "
			UPDATE " . self::TABLE . "
			SET
                            nome = '" . $this->db->escape($nome) . "',
                            descricao = '" . $this->db->escape($desc) . "',
                            ordem = " . $this->db->escape($ordem) . "
			WHERE id = $id
                ";
        } else {
            $query = "
			INSERT INTO " . self::TABLE . " (nome, descricao, ordem)
			VALUES (
                            '" . $this->db->escape($nome) . "',
                            '" . $this->db->escape($desc) . "',
                            " . $this->db->escape($ordem) . "
                        )
                ";
        }

        $this->db->executar($query);

        $id = ($this->db->getLastId() > 0) ? $this->db->getLastId() : $id;

        // CONJUNTO DE QUERIES PARA SER EXECUTADO AO FINAL
        $QUERIES = array();

        /*
         * FOTOS
         */
        // pega os ids de todas as fotos que estão no banco para esta atividade
        $idsAtuaisParaRemover = array();
        foreach ($this->db->executar("SELECT id FROM produto_foto WHERE produto = $id") as $resultid) {
            $idsAtuaisParaRemover[(int) $resultid["id"]] = (int) $resultid["id"];
        }

        // UPDATE e INSERT
        foreach ($fotos as $f) {
//            $SQLs[] = $l;
            $idFoto = $this->getParamInt(@$f["id"]);
            $mini = $this->getParam($f["mini"]);
            $foto = $this->getParam($f["foto"]);
            if ($idFoto) {
                // UPDATE
                $QUERIES[] = "UPDATE produto_foto SET mini = '" . $this->db->escape($mini) . "', foto = '" . $this->db->escape($foto) . "' WHERE id = $idFoto";
                unset($idsAtuaisParaRemover[$idFoto]);
            } else {
                // CREATE
                $QUERIES[] = "INSERT INTO produto_foto (produto, mini, foto) VALUES ($id, '" . $this->db->escape($mini) . "', '" . $this->db->escape($foto) . "')";
            }
        }

        // DELETE
        foreach ($idsAtuaisParaRemover as $idParaRemover) {
            $QUERIES[] = "DELETE FROM produto_foto WHERE id = $idParaRemover";
        }

        // EXECUTAR SQLs
        foreach ($QUERIES as $query) {
            $this->db->executar($query);
        }

        return $id;
    }

    /**
     * NÃO ALTERAR
     */
    public function getConfig() {
        return $CONFIG = array("TABLE" => self::TABLE, "TABLE_AS" => self::TABLE_AS, "CLASSE" => self::CLASSE);
    }

    public function getSelect() {
        return self::select();
    }

    public function getSelectExtra() {
        return self::selectExtra();
    }

    public function getJoin() {
        return self::join();
    }

    public function getJoinExtra() {
        return self::joinExtra();
    }

    public function getOrder() {
        return self::order();
    }

    public function getClassName() {
        return get_class($this);
    }

}
