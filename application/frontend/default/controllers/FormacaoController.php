<?php

include_once 'AbstractController.php';

class FormacaoController extends AbstractController
{

    public function indexAction()
    {
        $objServicos = new Servicos();
        $this->view->servicos = $this->getEventosByIds($objServicos->getFormacoes());
    }

    public function temAction() {
        // encontros novos
        $encontros[] = new Encontro("2020-01-01", "Percepção da Realidade", "Quem somos nós", "Jorg Saar");
        $encontros[] = new Encontro("2020-01-01", "C.G. Jung e os sonhos", "", "Nilma Saar");
        $encontros[] = new Encontro("2020-01-01", "Psicologia Transpessoal", "", "Nilma Saar");
        $encontros[] = new Encontro("2020-01-01", "Mente e Consciência", "o conceito dos campos na ciência e nas terapias holísticas", "Jorg Saar");
        $encontros[] = new Encontro("2020-01-01", "Estados Alterados da Consciência", "Patologia ou ferramenta de conexão?", "Jorg Saar");
        $encontros[] = new Encontro("2020-01-01", "Técnicas de ampliação da consciência - I", "Práticas meditativas", "Nilma Saar");
        $encontros[] = new Encontro("2020-01-01", "Técnicas de ampliação da consciência - II", "Stanislav Grof e a respiração holotrópica", "Jorg Saar");
        $encontros[] = new Encontro("2020-01-01", "Técnicas de ampliação da consciência - III", "Terapias Energéticas Multidimensionais,  Frequências de Brilho e Ámanae", "Nilma Saar");
        $encontros[] = new Encontro("2020-01-01", "A dimensão do sagrado no Xamanismo", "Ensinamentos transpessoais na obra de Carlos Castañeda", "Jorg Saar");
        $encontros[] = new Encontro("2020-01-01", "Terapias de Cuidado Paliativo", "Uma visão transpessoal da passagem", "Jorg Saar");
        $encontros[] = new Encontro("2020-01-01", "Como tornar-se terapeuta transpessoal", "a importância do olhar para dentro (inclusive: desafios e regulamentações) ", "Nilma e Jorg Saar");
        // 1. Percepção da Realidade – Quem somos nós? jorg Saar
        // 2. C.G. Jung e os sonhos; Nilma Saar
        // 3. Psicologia Transpessoal - a quarta força das psicologias; Nilma  Saar
        // 4. Mente e Consciência – o conceito dos campos na ciência e nas terapias - 
        // holísticas; Jorg Saar
        // 5. Estados Alterados da Consciência – Patologia ou ferramenta de conexão?  jorg Saar
        // 6. Técnicas de ampliação da consciência -I: Práticas meditativas; Nilma Saar
        // 7. Técnicas de ampliação da consciência -II: Stanislav Grof e a respiração
        // holotrópica; Jorg Saar
        // 8. Técnicas de ampliação da consciência -III: Terapias Energéticas 
        // Multidimensionais,  Frequências de Brilho e Ámanae; Nilma Saar
        // 9. A dimensão do sagrado no Xamanismo – Ensinamentos transpessoais na obra de
        // Carlos Castañeda; Jorg Saar
        // 10. Terapias de Cuidado Paliativo – Uma visão transpessoal da passagem; Jorg Saar
        // 11. Como tornar-se terapeuta transpessoal – a importância do olhar para dentro
        // (inclusive: desafios e regulamentações) Nilma e Jorg Saar


        // encontros antigos
        // $encontros[] = new Encontro("2020-09-29", "História da Psicologia", "", "Jörg");
        // $encontros[] = new Encontro("2020-10-06", "Percepção da Realidade", "Quem somos nós?", "Jörg");
        // $encontros[] = new Encontro("2020-10-13", "C.G. Jung e os Sonhos", "", "Jörg");
        // $encontros[] = new Encontro("2020-10-20", "Psicologia Transpessoal", "A Quarta Força", "Nilma");
        // $encontros[] = new Encontro("2020-10-27", "Mente e Consciência", "O Conceito dos Campos na Ciência e nas Terapias Holísticas", "Jörg");
        // $encontros[] = new Encontro("2020-11-03", "Terapias Energéticas Multidimensionais", "Um Condensado das Técnicas Atuais", "Nilma");
        // $encontros[] = new Encontro("2020-11-10", "Estados Alterados da Consciência", "Patologia ou Ferramenta de Conexão", "Jörg");
        // $encontros[] = new Encontro("2020-11-17", "Técnicas de Ampliação da Consciência I", "Práticas Meditativas", "Nilma");
        // $encontros[] = new Encontro("2020-11-24", "Técnicas de Ampliação da Consciência II", "Stanislav Grof e a Respiração Holotrópica", "Jörg");
        // $encontros[] = new Encontro("2020-12-01", "Técnicas de Ampliação da Consciência III", "Frequências de Brilho e Ámanae", "Nilma");
        // $encontros[] = new Encontro("2020-12-08", "A Dimensão do Sagrado no Xamanismo", "Ensinamentos Transpessoais na Obra de Carlos Castañeda", "Jörg");
        // $encontros[] = new Encontro("2020-12-15", "Terapias de Cuidado Paliativo", "Uma Visão Transpessoal da Passagem", "Nilma");
        // $encontros[] = new Encontro("2021-01-21", "O Saber e o Ser", "Como Tornar-se Terapeuta Transpessoal", "Jörg/Nilma");

        // view
        $this->view->encontros = $encontros;
        $this->view->whatsapp = "https://wa.me/5547999770213?text=Ol%C3%A1!%20Gostaria%20de%20mais%20informações%20sobre%20o%20curso%20TEM.";
    }

    public function ttiAction()
    {
        /**
         * Programa
         */
        $modulos[] = new Modulo("#E69C33", "Módulos Básicos", "B", "sexta a sábado", array(
            new Tema("B1", "2021-05-21", 14, "História da Psicologia", "Francisco A.P. Fialho"),
            new Tema("B7", "2021-06-18", 14, "Tradições Espirituais II – Taoismo, Taoismo japonês e Xintoismo", "Tiago Frosi"),
            new Tema("B2", "2021-07-16", 14, "Atuação e desafios do Terapeuta Transpessoal", "Eneida Lima de Oliveira"),
            new Tema("B3", "2021-08-21", 14, "Tradições Espirituais III – Espiritismo e Tradição Cristã", "Gerson Rocha"),
            new Tema("E10", "2022-09-11", 14, "Yoga e a Tradição Hinduísta", "Carol Abbiati"),
            new Tema("B5", "2021-10-22", 14, "Astrologia - Uma Abordagem Transpessoal", "Matheus Pozatti"),
            new Tema("B7", "2021-11-19", 14, "Física Quântica e Consciência", "Jörg Henri Saar"),
            new Tema("E5", "2021-12-17", 14, "Mandalas – Janela para a Alma", "Margareth Osório"),
            new Tema("E2", "2022-01-21", 14, "Estados Não Comuns de Consciência", "Jörg H. Saar"),
            new Tema("B8", "2022-03-18", 14, "Psicopatologia e Emergência Espiritual", "Jeverson Reichow"),
            new Tema("B10", "2022-04-22", 14, "Constelação Familiar", "Daniela Rossi"),
        ));
        $modulos[] = new Modulo("#A144AF", "Módulos Específicos", "E", "sexta a sábado", array(
            new Tema("E8", "2022-02-09", 14, "A Arte da Passagem - Tanatologia na Perspectiva Transdisciplinar, Transpessoal e Transcultural", "Roberto Crema"),
            new Tema("E3", "2022-05-13", 14, "Equilíbrio dos opostos – o Feminino e o Masculino", "Sergio Seixas e Lygia Franklin"),
            new Tema("E6", "2022-06-17", 14, "Sufismo e Dinâmica da Espiral", "Elgo Schwinn"),
            new Tema("E11", "2022-08-19", 14, "Metodologia Científica - O Poder da Palavra", "Vera Lúcia de Souza e Silva"),
            new Tema("E1", "2022-09-16", 14, "Psicoterapias PNL e Coaching Transpessoal", "Alexandre Magno"),
            new Tema("B11", "2022-10-22", 14, "Terapias Integrativas Energéticas", "Nilma J.F.S. Saar"),
            new Tema("E9", "2023-01-13", 14, "Regressão e Terapias de Vidas Passadas, DMP", "Mara Beatriz da Rocha"),
            new Tema("E7", "2023-02-17", 14, "Florais para o desenvolvimento da alma", "Anete Beatriz Effting"),
            new Tema("B9", "2023-03-17", 14, "Tradições Espirituais I – Meditação e a Tradição Budista", "Cerys Tramontini"),



            
        ));
        $modulos[] = new Modulo("#95BB3B", "Imersão", "M", "sexta a domingo", array(
            new Tema("M1", "2022-02-18", 26, "Mergulho na Respiração Integrativa", "Jörg + Nilma + facilitadores"),
            new Tema("M2/B6", "2022-07-16", 14, "Tradições Espirituais IV – Xamanismo", "Jeverson Reichow"),
            new Tema("M3/E4", "2022-11-18", 14, "Biodança – A cura por meio do movimento", "Rosa Maria Sá Brita Silveira"),
            new Tema("M4", "2023-04-14", 26, "Caminhada Terapêutica", "Jörg + Nilma"),
            
        ));
        $modulos[] = new Modulo("#333333", "Artigo e Estágio <small style='font-size:10px;'>(estágio não obrigatório)</small>", "C", null, array(
            new Tema("C1", "2023-01-02", 40, "Confecção de artigo científico", "Jörg + colegiado de terapeutas"),
            // new Tema("C2", "2020-09-18", 0, "Estágio com terapêuta em clínica ou espaço holístico", "Jörg + colegiado de terapeutas"),
        ));

        $this->view->modulos = $modulos;
        $this->view->objetivoGeral = array(
            "O objetivo deste curso é facilitar o aperfeiçoamento de pessoas para atuarem como Terapeuta Transpessoal, através de terapias transpessoais holísticas centradas em técnicas de ampliação da consciência. Neste intuito, o curso propõe-se a:",
            array(
                "Capacitar tanto pessoal como profissionalmente todas as pessoas que desejam atuar como facilitadores e multiplicadores desta abordagem de forma criativa, ética e espiritualizada. Para isto nos propomos facilitar o despertar de cada aluno em direção ao seu verdadeiro propósito e missão, aliando seu dom à sua capacitação pessoal e profissional através dos recursos transformadores que esta metodologia propicia;",
                "Favorecer a compreensão e a percepção da dinâmica do inconsciente em seus diversos níveis e estados, contribuindo desta forma para o seu autoconhecimento e aprimoramento pessoal e profissional, independente de sua área de atuação.",
            ),
        );
        $this->view->objetivosEspecificos = array(
            "Trazer o conhecimento teórico que fundamenta a Psicologia Transpessoal;",
            "Apresentar visões das tradições espirituais no mundo;",
            "Propiciar a cada participante experienciar através de sua metodologia vivencial os recursos e técnicas transpessoais com foco nas vivências em estado ampliado de consciência e, a partir da sua própria experiência, aprender a aplicar estas ferramentas nas diversas áreas de atuação;",
            "Formar Terapeutas, educadores, facilitadores e multiplicadores destas técnicas para uma atuação ética e comprometida com o novo paradigma holístico.",
        );

        /**
         * Público alvo
         */
        $this->view->publico = "O curso é destinado a pessoas de todas as áreas de formação, saúde, educação, organizações, terapeutas, com graduação completa, que tenham interesse em se aprofundar e se capacitar no uso da metodologia da Psicologia Transpessoal e seus recursos terapêuticos.";

        /**
         * Evento
         */
//        $this->view->evento = $this->getEvento(34);
        //        Eliti::print_r($this->view->evento);

        $this->view->whatsapp = "https://wa.me/5547999770213?text=Ol%C3%A1!%20Gostaria%20de%20mais%20informações%20sobre%20o%20curso%20TTI.";
    }

    public function tti1Action()
    {
        /**
         * Programa
         */
        $modulos[] = new Modulo("#E69C33", "Módulos Básicos", "B", "sexta a sábado", array(
            new Tema("B1", "2018-10-19", 14, "História da Psicologia", "Francisco A.P. Fialho"),
            new Tema("B4", "2018-11-09", 14, "Física Quântica e Consciência", "Jörg Henri Saar"),
            new Tema("B3", "2018-12-07", 14, "Teoria Integral e o Status das Terapias Integrativas no Brasil", "Tiago O. Frosi"),
            new Tema("B2", "2019-01-11", 14, "Atuação e desafios do Terapeuta Transpessoal", "Eneida Lima de Oliveira"),
            new Tema("B10", "2019-02-15", 14, "Constelação Familiar", "Daniela Rossi"),
            new Tema("B8", "2019-03-08", 14, "Psicopatologia e Emergência Espiritual", "Jeverson Reichow"),
            new Tema("B7", "2019-04-12", 14, "Tradições Espirituais III – Taoismo, Taoísmo japonês e Xintoismo", "Tiago Frosi"),
            new Tema("E5", "2019-05-17", 14, "Mandalas – Janela para a Alma", "Margareth Osório"),
            new Tema("B9", "2019-06-07", 14, "Tradições Espirituais IV – Meditação e a Tradição Budista", "Cerys Tramontini"),
            new Tema("B11", "2019-07-12", 14, "Terapias Integrativas Energéticas", "Nilma J.F.S. Saar"),
            new Tema("B5", "2019-08-09", 14, "Tradições Espirituais I – Tradição Cristã, Espiritismo", "Jorge Trevisol"),
        ));
        $modulos[] = new Modulo("#A144AF", "Módulos Específicos", "E", "sexta a sábado", array(
            new Tema("E1", "2019-09-13", 14, "Psicoterapias PNL e Coaching Transpessoal", "Alexandre Magno"),
            new Tema("E2", "2019-10-04", 14, "Estados Não Comuns de Consciência", "Jörg H. Saar"),
            new Tema("E3", "2019-11-08", 14, "Equilíbrio dos opostos – o Feminino e o Masculino", "Sergio Seixas e Lygia Franklin"),
            new Tema("E6", "2020-01-10", 14, "Sufismo e Dinâmica da Espiral", "Elgo Schwinn"),
            new Tema("E9", "2020-02-07", 14, "Regressão e Terapias de Vidas Passadas, DMP", "Mara Beatriz da Rocha"),
            new Tema("E4", "2020-03-06", 14, "Biodança – A cura por meio do movimento", "Rosa Maria Sá Brita Silveira"),
            new Tema("E7", "2020-04-03", 14, "Plantas medicinais e Homeopatia", "Fabiana de Barba"),
            new Tema("E8", "2020-05-15", 14, "A Arte da Passagem - Tanatologia na Perspectiva Transdisciplinar, Transpessoal e Transcultural", "Roberto Crema"),
            new Tema("E10", "2020-07-10", 14, "Yoga e a Tradição Hinduísta", "Anna Brigitta Kovács"),
            new Tema("E11", "2020-07-31", 14, "Metodologia Científica", "Lucas Pacheco Teixeira"),
        ));
        $modulos[] = new Modulo("#95BB3B", "Imersão", "M", "sexta a domingo", array(
            new Tema("B6", "2020-06-12", 14, "Tradições Espirituais II – Xamanismo", "Jeverson Reichow"),
            new Tema("M2", "2020-09-11", 26, "Imersão Final do Curso - 'Caminhada Terapêutica'", "Jörg + Nilma"),
            new Tema("M1", "2019-12-06", 26, "Mergulho na Respiração Integrativa", "Jörg + Nilma + facilitadores"),
        ));
        $modulos[] = new Modulo("#333333", "Estágio e Artigo", "C", null, array(
            new Tema("C1", "2020-09-18", 40, "Confecção de artigo científico", "Jörg + colegiado de terapeutas"),
            new Tema("C2", "2020-09-18", 0, "Estágio com terapêuta em clínica ou espaço holístico", "Jörg + colegiado de terapeutas"),
        ));

        $this->view->modulos = $modulos;
        $this->view->objetivoGeral = array(
            "O objetivo deste curso é facilitar o aperfeiçoamento de pessoas para atuarem como Terapeuta Transpessoal, através de terapias transpessoais holísticas centradas em técnicas de ampliação da consciência. Neste intuito, o curso propõe-se a:",
            array(
                "Capacitar tanto pessoal como profissionalmente todas as pessoas que desejam atuar como facilitadores e multiplicadores desta abordagem de forma criativa, ética e espiritualizada. Para isto nos propomos facilitar o despertar de cada aluno em direção ao seu verdadeiro propósito e missão, aliando seu dom à sua capacitação pessoal e profissional através dos recursos transformadores que esta metodologia propicia;",
                "Favorecer a compreensão e a percepção da dinâmica do inconsciente em seus diversos níveis e estados, contribuindo desta forma para o seu autoconhecimento e aprimoramento pessoal e profissional, independente de sua área de atuação.",
            ),
        );
        $this->view->objetivosEspecificos = array(
            "Trazer o conhecimento teórico que fundamenta a Psicologia Transpessoal;",
            "Apresentar visões das tradições espirituais no mundo;",
            "Propiciar a cada participante experienciar através de sua metodologia vivencial os recursos e técnicas transpessoais com foco nas vivências em estado ampliado de consciência e, a partir da sua própria experiência, aprender a aplicar estas ferramentas nas diversas áreas de atuação;",
            "Formar Terapeutas, educadores, facilitadores e multiplicadores destas técnicas para uma atuação ética e comprometida com o novo paradigma holístico.",
        );

        /**
         * Público alvo
         */
        $this->view->publico = "O curso é destinado a pessoas de todas as áreas de formação, saúde, educação, organizações, terapeutas, com graduação completa, que tenham interesse em se aprofundar e se capacitar no uso da metodologia da Psicologia Transpessoal e seus recursos terapêuticos.";

        /**
         * Evento
         */
//        $this->view->evento = $this->getEvento(34);
        //        Eliti::print_r($this->view->evento);
    }

    public function taiChiAction()
    {
        $this->view->evento = $this->getEvento(29);
//        Eliti::print_r($this->view->evento);
    }

}

class Modulo
{

    public $titulo;
    public $letra;
    public $periodo;
    public $temas;
    public $cor;

    public function __construct($cor, $titulo, $letra, $periodo = "", $temas = array())
    {
        $this->cor = $cor;
        $this->titulo = $titulo;
        $this->letra = $letra;
        $this->periodo = $periodo;
        $this->temas = $temas;
    }

    public function getHoras()
    {
        $total = 0;
        foreach ($this->temas as $t) {
            $total += $t->horas;
        }
        return $total;
    }

}

class Tema
{

    public $codigo;
    public $nome;
    public $professor;
    public $horas;
    public $data;

    public function __construct($c, $d, $h, $n, $p)
    {
        $this->codigo = $c;
        $this->data = $d;
        $this->horas = $h;
        $this->nome = $n;
        $this->professor = $p;
    }

}

// para o curso de TEM
class Encontro {


    public $date;
    public $title;
    public $subtitle;
    public $teacher;

    public function __construct($date, $title, $subtitle, $teacher)
    {
        $this->date = $date;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->teacher = $teacher;
    }
}
