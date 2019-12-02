<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="addCategory")
     * @return Response
     */
    public function addCategory(Request $request):Response
    {
        //$entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName('Comedie');

        $formCat = $this->createForm(
            CategoryType::class,
            $category
        );

        $formCat->handleRequest($request);

        if ($formCat->isSubmitted() && $formCat->isValid()) {

            $data = $this->getDoctrine()->getManager();

            $data->persist($category);
            $data->flush();
        }

        return $this->render('category/addCategory.html.twig',[
            'formCat' => $formCat->createView(),
        ]);
    }
}
