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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_tache_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TacheRepository $tacheRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Tache::class);
        // retrive the task
        $tache = $repo->findOneById($id);
        
        // retrive the user of the task
        $userID = $tache->getUser()->getId();
        
        // dd($userID);

        // Retrieve the authenticated user
        $loggedInUserID = $this->security->getUser()->getId();
        // dd($loggedInUserID);
        if($userID != $loggedInUserID){
            return $this->redirectToRoute('security_login');
        }

        if($tache->getStatus() == 'Open'){
            $tache->setStatus('In Progress');
            // dd($tache);
            $em->persist($tache);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_tache_mytasks');
        }
       

        return $this->redirectToRoute('app_tache_mytasks');

    }

    /**
     * @Route("/{id}/end", name="app_tache_end")
     */
    public function endTask(Request $request , $id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Tache::class);
        // retrive the task
        $tache = $repo->findOneById($id);
        
        // retrive the user of the task
        $userID = $tache->getUser()->getId();
        
        // dd($userID);

        // Retrieve the authenticated user
        $loggedInUserID = $this->security->getUser()->getId();
        // dd($loggedInUserID);
        if($userID != $loggedInUserID){
            return $this->redirectToRoute('security_login');
        }

        $tache_livrables = $tache->getLivrables()->getValues();
       
        
        if($tache->getStatus() == 'In Progress' && $tache_livrables != null){
            $tache->setStatus('Waiting For Validation');
            // dd($tache);
            $em->persist($tache);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_tache_mytasks');
        }
       

        return $this->redirectToRoute('app_tache_mytasks');

    }

    
    /**
     * @Route("/{id}/validate", name="app_tache_validate")
     */
    public function validateTask(Request $request , $id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Tache::class);
        // retrive the task
        $tache = $repo->findOneById($id);
        
        $tache_livrables = $tache->getLivrables()->getValues();
       
      
        if($tache->getStatus() == 'Waiting For Validation' && $tache_livrables != null){
            $tache->setStatus('Finished');
            
            $em->persist($tache);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_tache_mytasks');
        }
       

        return $this->redirectToRoute('app_tache_index');

    }
    
}
