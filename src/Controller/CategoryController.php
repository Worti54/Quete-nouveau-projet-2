<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/category", name="category_index")
     * @return Response A response instance
     */
    public function index(Request $request) : Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            $categoryEntity = $this->getDoctrine()->getManager();
            $categoryEntity->persist($category);
            $categoryEntity->flush();

            return $this->redirectToRoute('category_index');

        }


        return $this->render(
            'category/index.html.twig', [
                'categories' => $categories,
                'form' => $form->createView(),
            ]
        );


    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show(Category $category) :Response
    {

        return $this->render('category/show.html.twig', ['category'=>$category]);
    }
}
