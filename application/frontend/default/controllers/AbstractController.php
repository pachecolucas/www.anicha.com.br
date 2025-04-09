<?php

abstract class AbstractController extends Eliti_Controller {

    public function init() {
        parent::init();
        /**
         * SOCIAIS
         */
        $this->view->sociais = array(
            array("nome" => "Facebook", "link" => "https://www.facebook.com/anichaholistica/", "icon" => "fa fa-facebook", "class" => "si-colored-facebook", "class2" => "si-facebook"),
            array("nome" => "Instagram", "link" => "https://www.instagram.com/anicha.terapias/", "icon" => "fa fa-instagram", "class" => "si-colored-google-plus", "class2" => "si-g-plus"),
        );

        /**
         * MENU
         */
        $menu = new Menu();
        $menu->add(new MenuItem("<i class='fa fa-home'></i>", "/"));
        $menu->add(new MenuItem("Quem somos", "/quem-somos"));
        $menu->add(new MenuItem("Agenda", "/agenda"));
        $menu->add(new MenuItem("Holopráxis", "holopraxis", array(
            // new MenuItem("Círculo Meditações", "/holopraxis/meditacao"),
            new MenuItem("Danças Circulares", "/holopraxis/dancas-circulares"),
            new MenuItem("Meditação", "/holopraxis/meditacao"),
            new MenuItem("Meditação Pleiadiana", "/holopraxis/meditacao-pleiadiana"),
            // new MenuItem("Yoga", "/holopraxis/yoga"),
                ), Menu::HOLOPRAXIS));
        $menu->add(new MenuItem("Atendimentos", "atendimento", array(
            new MenuItem("Ámanae", "/atendimento/amanae"),
            new MenuItem("Apometria", "/atendimento/apometria"),
            // new MenuItem("Barra de Access", "/atendimento/barra-de-access"),
            // new MenuItem("Coaching de Vida", "/atendimento/coaching-de-vida"),
            new MenuItem("Frequências de Brilho", "/atendimento/frequencias-de-brilho"),
            new MenuItem("Polaridade Sistêmica", "/atendimento/polaridade-sistemica"),
            new MenuItem("Processo de Transformação Emocional", "/atendimento/pte"),
            // new MenuItem("Reiki", "/atendimento/reiki"),
            // new MenuItem("Respiração Integrativa", "/atendimento/respiracao-integrativa"),
                ), Menu::ATENDIMENTO));
        // $menu->add(new MenuItem("Pós-graduação", "/tti"));
        $menu->add(new MenuItem("Formações", "formacao", array(
            // new MenuItem("<small>PÓS-GRADUAÇÃO</small><br>Terapias Transpessoais Integrativas", "/tti"),
            new MenuItem("<small>CURSO ABERTO</small><br>Terapias Energéticas Multidimensionais", "/tem"),
                ), Menu::ATENDIMENTO));
        $menu->add(new MenuItem("Contato", "/contato"));
        $this->view->menu = $menu;

        /**
         * TELEFONES
         */
        $this->view->telefones = array(
            "(47) 99977-0213"
        );

        /**
         * ENDEREÇO
         */
        $this->view->address = "Rua Otto Wagner, 88<br>Velha - Blumenau - SC<br>CEP 89042-290";
    }

    protected function getEventoNoCalendario($id) {
        $result = $this->getRemoteJson("https://meu.epanel.com.br/external/agenda-calendario/company/14/id/{$id}");
        if ($result->classe === "Eliti_Response_Success_Object") {
            return $result->object;
        }
    }

    protected function getEvento($id) {
        $result = $this->getRemoteJson("https://meu.epanel.com.br/external/agenda-evento/company/14/id/{$id}");
        if ($result->classe === "Eliti_Response_Success_Object") {
            return $result->object;
        }
    }

    protected function getTexto($id) {
        $eventos = $this->getRemoteJson("https://meu.epanel.com.br/external/texto/id/all/company/14/id/$id");
        if ($eventos && $eventos->object) {
            return $eventos->object;
        }
        return array();
    }

    protected function getEventos() {
        $eventos = $this->getRemoteJson("https://meu.epanel.com.br/external/agenda-calendario/id/all/company/14");
        if ($eventos && $eventos->objects) {
            return $eventos->objects;
        }
        return array();
    }

    public function getEventosByIds($ids) {
        $idsStr = implode(",", $ids);
        $result = $this->getRemoteJson("https://meu.epanel.com.br/external/agenda-evento/company/14/id/all/ids/{$idsStr}");
        if ($result->classe === "Eliti_Response_Success_Objects") {
            return $result->objects;
        }
    }

    protected function getRemoteJson($url) {

        // Inicia
        $curl = curl_init();

        // Configura
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);

        // Envio e armazenamento da resposta
        $response = curl_exec($curl);

        // Fecha e limpa recursos
        curl_close($curl);

        // retorna JSON
        return json_decode($response);
    }

    public $MESES = array("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");

    protected function prepararEventos(&$eventos) {
        $anterior = "";
        foreach ($eventos as $e) {
            $e->mesAno = null;
            $mesAno = substr($e->data, 0, 7);
            if ($anterior != $mesAno) {
                $mes = (int) substr($mesAno, 5, 2);
                $e->mesAno = $this->MESES[$mes - 1];
            }
            $anterior = $mesAno;
        }
        return $eventos;
    }

}

class Menu {

    public $itens = array();

    const HOLOPRAXIS = 1;
    const ATENDIMENTO = 2;
    const FORMACAO = 3;
    const EVENTO = 4;

    public function add(MenuItem $i) {
        $this->itens[] = $i;
    }

    public function getByTipo($tipo) {
        foreach ($this->itens as $i) {
            if ($i->tipo === $tipo) {
                return $i;
            }
        }
    }

}

class MenuItem {

    public $nome;
    public $link;
    public $itens = array();
    public $tipo;

    public function __construct($nome, $link, $subItens = array(), $tipo = null) {
        $this->nome = $nome;
        $this->link = $link;
        $this->itens = $subItens;
        $this->tipo = $tipo;
    }

    public function add(MenuItem $i) {
        $this->itens[] = $i;
    }

}

class Servicos {

    const TIPO_HOLOPRAXIS = 11;
    const TIPO_EVENTO = 13;
    const TIPO_ATENDIMENTO = 14;
    const TIPO_FORMACAO = 12;
    const MEDITACAO = 31;
    const DANCAS = 27;
    const YOGA = 32;
    const TTI = 34;
//    const TAICHI = 29;
    const AMANAE = 23;
    const TTE = 24;
    const TEM = 130;
    const BARRADEACCESS = 25;
    const RESPIRACAO = 26;
    const COACHING = 28;
    const FREQUENCIA = 22;
    const APOMETRIA = 61;

    public function getAll() {
        $all = array(
            $this->getAtentimentos(),
            $this->getHolopraxis(),
            $this->getFormacoes(),
        );
        $allFlat = new RecursiveIteratorIterator(new RecursiveArrayIterator($all));
        $allFinal = array();
        foreach ($allFlat as $v) {
            $allFinal[] = $v;
        }
        return $allFinal;
    }

    public function getHolopraxis() {
        return array(
            self::MEDITACAO,
            self::DANCAS,
            // self::YOGA,
        );
    }

    public function getAtentimentos() {
        return array(
            self::AMANAE,
            // self::TTE,
            // self::BARRADEACCESS,
            // self::RESPIRACAO,
            // self::COACHING,
            self::FREQUENCIA,
        );
    }

    public function getFormacoes() {
        return array(
            // self::TTI,
            self::TEM,
        );
    }

}
