<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tag;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag")
     */
    public function index()
    {
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAll();
        return $this->render('tag/index.html.twig', [
            'tags'=>$tags,

        ]);
    }
    /**
     * @param string $name The slugger
     * @Route("/tag/{name}", name="tag_show")
     * @return Response A response instance
     */
    public function show(string $name) :Response
    {
        $tagRepository = $this->getDoctrine()
            ->getRepository(Tag::class);
        $tag = $tagRepository->findOneBy(['name'=>$name]);

        $articles= $tag->getArticles();

        return $this->render(
            'tag/show.html.twig',
            [
                'tag' => $tag,
                'name' => $name,
                'articles'=>$articles,

            ]
        );
    }
}
