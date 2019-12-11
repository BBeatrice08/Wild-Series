<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
/*
        $form = $this->createForm(
            ProgramSearchType::class,
            null,
            ['method' => Request::METHOD_GET]
        );

        /*
        $category = new Category();
        $formCat = $this->createForm(
            CategoryType::class,
            $category
        );

        $formCat->handleRequest($request);

        if ($formCat->isSubmitted()) {
            $data = $formCat->getData();
            // $data contains $_POST data
            // TODO : Insertion dans bdd
            //créér un category controller, l'extends, lui faire une méthode add (issu de doctrine)
            //et ajouter $data en bdd
            $data = $formCat->addCategory();
            dd($data);
        }
        */
        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('wild/index.html.twig', [
            'programs' => $programs,
            //'form' => $form->createView(),

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
     * @Route("/category/{categoryName}", defaults={"categoryName" = null}, name="category")
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

    /**
     * Getting a season with a formatted slug title
     *
     * @param string $slug The slugger
     * @Route("/showByProgram/{slug<^[a-zA-Z0-9- ]+$>}", defaults={"slug" = null}, name="showByProgram")
     * @return Response
     */
    public function showByProgram(?string $slug):Response
    {
        if (!$slug) {
            throw $this->createNotFoundException('No slug has been sent to find a program');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $programName = $this->getDoctrine()
            ->getManager()
            ->getRepository(Program::class)
            //->findBy(['title' => $slug]);
            ->findOneBy(['title' => $slug]);

        $programId = $programName->getId();


        $listSeason = $this->getDoctrine()
            ->getRepository(Season::class)
            //->findAll();
            ->findBy(
                ['program' => $programId],
                ['id' => 'desc'],
                6,
                0
            );


        //dd($slug, $programName);

        if (!$programName) {
            throw $this->createNotFoundException(
                'No program with this '.$slug.' title'
            );
        }

        return $this->render('wild/program.html.twig', [
            'programName' => $programName,
            'slug' => $slug,
            'listSeason' => $listSeason
        ]);

    }

    /**
     * Getting a program by a season
     *
     * @param integer $id
     * @Route("/showBySeason/{id}", defaults={"id" = null}, name="showBySeason")
     * @return Response
     */
    public function showBySeason(?int $id):Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);

        $program = $season->getProgram()->getTitle();

        $episode = $season->getEpisode()->toArray();

        return $this->render('wild/season.html.twig', [
            'season' => $season,
            'episode' => $episode,
            'program' => $program
        ]);
    }

    /**
     *
     *
     * @Route("/episode/{id}", defaults={"id" = null}, name="episode")
     *
     */
    public function showEpisode(Episode $episode):Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram()->getTitle();

        //dd($season, $program, $episode);

        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program
        ]);
    }


    /*
    public function new(): Response
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'wild_show', correspondant à l'url wild/show/5
        return $this->redirectToRoute('wild_show', ['page' => 1]);
    }
    */


}
