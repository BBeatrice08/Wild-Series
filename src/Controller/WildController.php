<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
Class WildController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        return $this->render('wild/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     * Getting a program in a category
     *
     * @param string $categoryName
     * @Route("/showByCategory/{categoryName}", defaults={"categoryName" = null}, name="showByCategory")
     * @return Response
     */
    public function showByCategory(?string $categoryName):Response
    {
        $categoryName = $this->getDoctrine()
            ->getManager()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $categoryId = $categoryName->getId();

        if ($categoryId) {
            $listProgram = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findBy(
                    ['category' => $categoryId],                        // critère
                    ['id' => 'desc'],                                   // Tri
                    3,                                              // limite
                    0                                           // offset
                );
        }
        if (!$categoryName) {
            throw $this->createNotFoundException(
                'No category with name found in categories table.'
            );
        }

        return $this->render('wild/category.html.twig', [

            'categoryName' => $categoryName,
            'listProgram' => $listProgram
        ]);
    }


    public function new(): Response
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'wild_show', correspondant à l'url wild/show/5
        return $this->redirectToRoute('wild_show', ['page' => 1]);
    }


    /*
    /**
     * @Route("wild/watch/{slug}",
     *     requirements={"slug"="[A-Za-z0-9\-]"},
     *     name="wild_show")
     */
    /*
    public function watch(string $slug = "a-b"): Response
    {
        return $this->redirectToRoute('wild/show.html.twig', [
            'slug' => $slug
        ]);
    }
    */

}