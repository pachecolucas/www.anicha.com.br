<?php

include_once 'AbstractController.php';

class QuemSomosController extends AbstractController
{

    public function indexAction()
    {
        $this->view->membros = array(
            // array("Jesse Eustis", "team-jesse.jpg", "
            //     Terapeuta e Professor de Amanae. Desde que ele descobriu o Amanae, há mais de 10 anos, Jesse embarcou numa busca interessantepara viver a vida a partir do coração. Atualmente ele pratica e ensina Amanae no Brasil, California do Norte e Minnesota; viajando internacionalmente para compartilhar este trabalho em workshops e sessões individuais.
            //     "),
            //            array("Terezinha Aparecida Alves Carneiro", "team-terezinha.webp", "
            //                Psicologa e Psicoterapeuta em Psicodrama - Graduada em Psicologia clínica, escolar e organizacional (UNIVALI), Pós graduada em Psicodrama (UNIVALI), Formada em Sócio-Psicomotricidade (CESIR - RJ), pós graduada em saúde da família (UNIASELVI), pós graduada em Psicologia Transpessoal (UNIPAZ SUl).
            //                "),
            //            array("Kimtara", "team-kimtara.jpg", "
            //                Kimtara é economista, com MBA em Relações Internacionais e, após ouvir o chamado de sua alma, se moveu num ângulo de 180° graus, passando a atuar na área de Parapsicologia, Psicologia Transpessoal, Numerologia, Astrologia e Alquimia.
            //Há mais de 10 anos atua em Consultorio próprio onde já fez a leitura de mais de 1.000 Mapas.
            //Já impactou positivamente a vida de milhares de pessoas que de verdade buscam por algo a mais na vida: conexão, profundidade e em um encontro consigo mesmo.
            //                "),
            //            array("Márcio Zimermann", "team-marcio.jpg", "
            //               Primeiro ciclo do movimento Guerreiros do coração em 2016 e Fazendo segundo ciclo 2018.
            //               Reiki I e II ano 2017.
            //Curso 10 dias Meditação Vipassana - Rio de Janeiro ano 2017.
            //Conduz Meditação no Espaço Anicha e Espaço Celeste - Indaial.
            //Formação Hatha Yoga - Espaço Ganech 11 meses ano 2017/2018.
            //Instrutor de yoga e Meditação Personal.
            //Aplica massagem Ativa o Corpo.
            //                "),
            // array("Ronaldo Naradeva Shankar", "team-ronaldo.jpg", "
            //     Fisioterapeuta, terapeuta holístico pós-graduado em microfisioterapia. Professor de Power yoga, RPG YOGA e especializado em técnicas multidimensionais de cura física e espiritual.
            //     Formado na primeira escola de Amanae do Brasil, com a embaixatriz pleiadiana Christine Day.
            //     Seus trabalhos vão desde o toque sutil ao profundo, abrindo portais e liberando memórias de dor e traumas.
            //     Trouxe muitas técnicas da Europa, após passar uma temporada em Portugal se especializando em novas técnicas de cura, como abertura de Registros Ákashicos e Terapia Multidimensional (Técnica Francesa). Iniciado em Xamanismo (Temazcal com os índios Andinos), no Peru.
            //     "),
//            array("Alexandre Thibes", "team-alexandre.jpg", "
            //                Terapeuta Energético Transpessoal. Especialista em Psicologia transpessoal pela UNIPAZ Sul, mestre em Reiki pela escola profissionalizante André Luiz (CELER Faculdades), Cromoterapeuta pela Sociedade de Estudos Espírita Casa do Caminho.
            //Utiliza-se de técnicas energéticas como Reiki,  reequilíbrio da aura, alinhamento dos chakras, cromoterapia, visualização criativa, aromaterapia, fitoterapia, em suas seções com o objetivo de auxiliar as pessoas a encontrarem seu próprio equilíbrio, sua própria cura. Também atende Barra de Access, uma técnica que nos permite sair do piloto automático promovendo mudanças em todos os aspectos da vida com facilidade.
            //                "),
            // array("Juliana Goldfeder Sgrott", "team-ju.jpg", "
            //     Formada Bacharel em Teatro e em Hatha Yoga, traz em seu repertório de vida a consciência corporal, desde a infância, aliada à Dança como meio de se expressar. Atualmente se dedica a Yoga para o Parto, mergulhando na preparação da mãe e bebê para sua chegada. Secretária no Espaço Anicha.
            //     "),
            //            array("Daniel Della Valle", "team-daniel.jpg", "
            //                Natural do Uruguai é Iridologo, Naturoterapeuta, Master de Reiki, Terapeuta Floral, Cromoterapeuta, Radestesista, Geoterapeuta, Hidroterapeuta. Estudou em Espacio Yin-Yang de Terapias Holísticas (Montevideo-Uruguai), Centro Holístico Energía Vital (Canelones-Uruguai) e formou-se em Iridologia Franco-espanhola com o Nutrólogo e médico Ortomolecular Mario Fontana del Castillo. Participa como Professor de Iridologia em cursos profissionalizantes das escolas ICSINA e INNAP de Curitiba e como Professor de extensão na UNICRUZ, Cruz Alta.  Realiza atendimentos no Brasil desde junho de 1995 como Naturólogo com enfoque holístico, integral e humano.
            //                "),
            // array("Gabriela Cavalheiro", "team-gabi.jpg", "
            //     Psicóloga, Gestalt-terapeuta, clínica individual com adolescentes e adultos. Facilitadora de grupos de mulheres e adolescentes, Clã das Mulheres Lobas e Clã Florescer em Contos
            //     "),
            // array("Carolina Abbiati", "team-carolina.jpg", "
            // Terapeuta Reiki.
            // Mestre em Reiki Xamânico.
            // Aluna da Pós-graduação em Terapias Transpessoais Integrativas
            // e Capacitação para Instrutor de Yoga.
            //         "),
            // array("David Korb", "team-david.jpg", "
            //         Terapeuta Reiki nos níveis I e II pelo sistema Usui de cura natural.
            //         Intérprete do tarô Zen do Osho.
            //         Aluno de Capacitação para Instrutor de Yoga.
            //         Secretário e recepcionista no Espaço Anicha.
            //             "),
            // array("Lucas Pacheco Teixeira", "team-lucas.jpg", "
            //     Desenvolvedor de sistemas na <a href='http://epanel.com.br'>Epanel</a>; designer na <a href='http://abugio.com.br'>Bugio</a>; consultor e facilitador financeiro na <a href='http://epanel.com.br'>Cashimbo</a>; professor e fundador da <a href='http://eliti.com.br'>Eliti</a>; palestrante, numerólogo e astrólogo no Anicha. É graduado em Sistemas de Informação na UFSC onde também estudou Contabilidade e Educação. Foi iniciado aos 16 anos nos estudos de Numerologia e Alquimia, posteriormente viveu grandes experiências vivendo junto à Cordilheira do Andes acompanhado por dois lamas budistas. Estudou Astrologia com Sandesh Ferrari. Oferece palestras capazes de combinar assuntos científicos e esotéricos trazendo luz à vida interior. Dedica-se à construção de uma Escola de 8 Dimensões para as Crianças do Futuro.
            //     "),
            // array("Cida Oliveira", "team-cida.jpg", "
            //     Massoterapeuta e Terapeuta Holística há 16 anos. Formada pelo Centro Muller em Massagem e Alinhamento Vertebral. Formação em Reiki nos níveis I, II e III pelo sistema Osho e pelo sistema Usui. Argiloterapia pela Pastoral da Saúde. Shiatsu e Reflexologia no IMO (Instituto de Medicina Oriental). Naturopatia Vibracional pelo CIEPH (Centro Integrado de Estudos e Pesquisa do Homem). Cursando Psicologia Transpessoal pela Unipaz no Espaço Anicha.
            //     "),
        );
    }

}
