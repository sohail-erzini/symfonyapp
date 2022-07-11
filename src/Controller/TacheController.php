<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\User;
use App\Form\TacheType;
use App\Repository\LivrableRepository;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/tache")
 */
class TacheController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }


    /**
     * @Route("/mytasks", name="app_tache_mytasks", methods={"GET"})
     */
    public function myTasksIndex( EntityManagerInterface $em): Response
    {

         // returns User object or null if not authenticated
         $user = $this->security->getUser();
        //  dd($user);
        //  dd($user->getUserIdentifier());
        $taches = $user->getTaches()->getValues();
        // dd($taches);

        return $this->render('tache/mytasks.html.twig', [
            'taches' => $taches
        ]);
    }

    /**
     * @Route("/", name="app_tache_index", methods={"GET"})
     */
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_tache_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TacheRepository $tacheRepository): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tacheRepository->add($tache, true);

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tache_show", methods={"GET"})
     */
    public function show(Tache $tache, LivrableRepository $livrableRepository): Response
    {
        $livrable = $livrableRepository->findliv($tache);
        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
            'livrable' => $livrable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_tache_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tacheRepository->add($tache, true);

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tache_delete", methods={"POST"})
     */
    public function delete(Request $request, Tache $tache, TacheRepository $tacheRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->request->get('_token'))) {
            $tacheRepository->remove($tache, true);
        }

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/{id}/start", name="app_tache_start")
     */
    public function startTask(Request $request , $id , EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Tache::class);
        // retrive the task
        $tache = $repo->findOneById($id);

        // retrive the user of the task
        $user = $tache->getUser();

        // Retrieve the authenticated user
        $loggedInUser = $this->security->getUser();
        if($user->getId() == $loggedInUser){
            echo 'sohail erzini';
            die();
        }

        

    }

    
}
