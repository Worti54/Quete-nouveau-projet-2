<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController

{
    /**
     * @Route("/blog/",  name="blog")
     */
    public function blog()
    {
        $titre = "Article Sans Titre";
        return $this->render('blog/index.html.twig', ['titre' => $titre]);
    }

 /**
 * @Route("/blog/{page}", requirements={"page"="\d+"}, name="blog_list")
 */
    public function list($page)
    {
        return $this->render('blog/index.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/blog/{slug}", requirements={"slug"="[a-z0-9\-]+"}, name="blog_show")
     */
    public function show($slug)
    {
        $preTitre =  str_replace ( "-", " ", $slug);
        $titre = ucwords($preTitre, " ");
        return $this->render('blog/index.html.twig', ['titre' => $titre]);
    }
}

