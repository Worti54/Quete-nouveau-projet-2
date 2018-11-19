<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Form\ArticleType;

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
        if ($form->isSubmitted()&& $form->isValid())
        {
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
}
