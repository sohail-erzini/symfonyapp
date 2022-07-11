<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/search", name="search")
     */
    public function search(ProjetRepository $projetRepository,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $proj = $request->query->get('proj');
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->SearchProj($proj),
        ]);
    }
}
