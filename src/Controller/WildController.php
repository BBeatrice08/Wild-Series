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
     * @Route("/showByProgram/{slug<^[a-zA-Z0-9-]+$>}", defaults={"slug" = null}, name="showByProgram")
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

        if ($programId) {
            $listSeason = $this->getDoctrine()
                ->getRepository(Season::class)
                //->findAll();
                ->findBy(
                    ['program' => $programId],
                    ['id' => 'desc'],
                    6,
                    0
                );
        }


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



    /*
    public function new(): Response
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'wild_show', correspondant à l'url wild/show/5
        return $this->redirectToRoute('wild_show', ['page' => 1]);
    }
    */


}