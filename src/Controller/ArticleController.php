<?php

namespace App\Controller;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\CategoryType;
use App\Form\ArticleType;
use App\Entity\Tag;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(Request $request)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleEntity = $this->getDoctrine()->getManager();
            $articleEntity->persist($article);
            $articleEntity->flush();

            return $this->redirectToRoute('article');

        }


        return $this->render(
            'article/index.html.twig', [
                'articles' => $articles,
                'form' => $form->createView(),
            ]
        );

    }

    /**
     * @param integer $id The slugger
     * @Route("/article/{id}", name="article_show")
     * @return Response A response instance
     */
    public function show(int $id) :Response
    {
        $articleRepository = $this->getDoctrine()
            ->getRepository(Article::class);
        $article = $articleRepository->find($id);

        $tags = $article->getTags();

        return $this->render(
            'article/show.html.twig',
            [
                'article' => $article,
                'id' => $id,
                'tags'=>$tags,

            ]
        );
    }
}
