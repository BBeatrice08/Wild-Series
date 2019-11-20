<?php
// src/Controller/WildController.php
namespace App\Controller;

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
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/show/{page}",
     *     requirements={"page"="[a-z0-9\-]+"},
     *     methods={"GET"},
     *     defaults={"page"= "Aucune série sélectionnée, veuillez choisir une série"},
     *     name="show")
     * @param $page
     * @return Response
     */
    public function show(?string $page): Response
    {
        if (!$page) {
            throw $this
                ->createNotFoundException('');
        }
        $replace = str_replace('-', ' ', $page);
        $upperCase = ucwords($replace);


        return $this->render('wild/show.html.twig', [
            'upperCase' => $upperCase
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