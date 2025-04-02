<?php

include_once 'AbstractController.php';

class BlogController extends AbstractController {

    public function indexAction() {
        $this->view->classe = "blog-list";
        $this->view->total = $this->getRemoteJson("https://meu.epanel.com.br/external-especial/blog/total/company/5")->object->total;
        $this->view->limit = 2;
        $this->view->offset = $this->getParamInt("offset");
        $this->view->posts = $this->getRemoteJson("https://meu.epanel.com.br/external/blog-post/company/5/limit/{$this->view->limit}/offset/{$this->view->offset}")->objects;
        foreach ($this->view->posts as $p) {
            $p->resumo = substr(strip_tags($p->texto), 0, 253);
        }
        $this->view->ogTitle = "Blog - Madri Seguros";
    }

    public function postAction() {
        $this->view->classe = "blog-single";
        $id = $this->getParamInt("id");
        $this->view->post = $this->getRemoteJson("https://meu.epanel.com.br/external/blog-post/id/$id/ef-locale/" . LOCALE)->object;
        $this->view->ogUrl = "http://madricorretora.com.br/blog/post/id/" . $this->view->post->id;
//        $this->view->ogTitle = $post->titulo;
//        if ($post->hasFoto) {
//            $this->view->ogImage = $post->hasFotoGrande ? $post->fotoGrande : $post->foto;
//        }
//        $this->view->post = $post;
    }

}
