<?php

namespace App\Controller;

use App\Service\FilmService;
use App\Service\LogService;
use App\Service\LogUwUService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FournisseurController extends AbstractController
{

    private LogService $logService;
    private FilmService $filmService;
    private MailerService $mailService;
    private LogUwUService $logUwUService;

    public function __construct(
        LogService $logService,
        FilmService $filmService,
        MailerService $mailService,
        LogUwUService $logUwUService,
    ) {
        $this->logService = $logService;
        $this->filmService = $filmService;
        $this->mailService = $mailService;
        $this->logUwUService = $logUwUService;
    }

    #[Route('/', name: 'list')]
    public function listFilms()
    {
        $films = [];
        try {
            $films = $this->filmService->listFilms();
        }
        catch (\Exception $e) {
            $this->addFlash("error", $e->getCode().': '.$e->getMessage());
        }
        return $this->render('films/list.html.twig', [
            'films' => $films
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addFilm(Request $request, )
    {
        $film = [];

        if ($request->isMethod("POST")) {
            $film = [
                'title' => $request->request->get('title'),
                'isbn' => $request->request->get('isbn'),
                'author' => $request->request->get('author'),
                'description' => $request->request->get('description'),
                'publicationDate' => $request->request->get('publicationDate'),
            ];

            try {
                $this->filmService->addFilm($film);
                $this->addFlash("success", "OK");
                
                $this->logService->log("success", "Nouveau film publié : " . $film['title']);
                $this->logUwUService->log("success", "Nouveau film publié : " . $film['title']);
                $this->mailService->send(
                    "admin@microservices.cesi.fr",
                    "Nouveau film publié : " . $film['title'],
                    "Tout est dans le titre"
                );

                return $this->redirectToRoute('list');
            }
            catch (\Exception $e) {
                $this->addFlash("error", $e->getCode().': '.$e->getMessage());
            }
        }

        return $this->render("films/add.html.twig", [
            'action' => 'add',
            'film' => $film
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editFilm(int $id, Request $request)
    {
        $film = $this->filmService->getFilm($id);

        if ($request->isMethod("POST")) {
            $film = [
                'id' => $request->request->get('id'),
                'title' => $request->request->get('title'),
                'isbn' => $request->request->get('isbn'),
                'author' => $request->request->get('author'),
                'description' => $request->request->get('description'),
                'publicationDate' => $request->request->get('publicationDate'),
            ];

            try {
                $this->filmService->editFilm($film);
                $this->addFlash("success", "OK");

                $this->logService->log("success", "Film modifié : " . $film['title']);
                $this->logUwUService->log("success", "Film modifié : " . $film['title']);

                return $this->redirectToRoute('list');
            }
            catch (\Exception $e) {
                dump($e);
                $this->addFlash("error", $e->getCode().': '.$e->getMessage());
            }
        }

        return $this->render("films/add.html.twig", [
            'action' => 'edit',
            'film' => $film,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteFilm(int $id)
    {
        try {
            $film = $this->filmService->getFilm($id);
            $this->filmService->deleteFilm($id);
            $this->addFlash("success", "Film supprimé !");

            $this->logService->log("success", "Film supprimé : " . $film['title']);
            $this->logUwUService->log("success", "Film supprimé : " . $film['title']);
        }
        catch (\Exception $e) {
            $this->addFlash("error", $e->getCode().': '.$e->getMessage());
        }
        return $this->redirectToRoute('list');
    }

    #[Route('/testemail')]
    public function testEmail()
    {
        $this->mailService->send(
            "admin@microservices.cesi.fr",
            "test",
            "Tout est dans le titre"
        );
        return new Response();
    }

    #[Route('/testloguwu')]
    public function testLogUwu()
    {
        $this->logUwUService->log("success", "test");
        return new Response();
    }
}
