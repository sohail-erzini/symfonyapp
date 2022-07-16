<?php

namespace App\Controller;

use App\Entity\Phase;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\PhaseRepository;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/projet")
 */
class ProjetController extends AbstractController
{
    /**
     * @Route("/", name="app_projet_index", methods={"GET"})
     */
    public function index(ProjetRepository $projetRepository): Response
    {
        // AELH : redirect to login if tried to access via route
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_OWNER")
     * @Route("/new", name="app_projet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProjetRepository $projetRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setEtat('Open');
            
            $projetRepository->add($projet, true);

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_projet_show", methods={"GET"})
     */
    public function show(Projet $projet , ManagerRegistry $em , $id, PhaseRepository $phaseRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $em->getRepository(Projet::class);
        $projet = $repo->find($id);

        $userProjets = $projet->getUserProjets()->getValues();
        // dd($userProjets);

        //AELH check repo
        $phases = $phaseRepository->ShowProjectPhase($id);


        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
            'employees' => $userProjets,
            'phases' => $phases
        ]);
    }

    /**
     * @IsGranted("ROLE_OWNER")
     * @Route("/{id}/edit", name="app_projet_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projetRepository->add($projet, true);

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_OWNER")
     * @Route("/{id}", name="app_projet_delete", methods={"POST"})
     */
    public function delete(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $projetRepository->remove($projet, true);
        }

        return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
    }

    
    /**
     * @IsGranted("ROLE_OWNER")
     * @Route("/{id}/launch", name="app_projet_launch")
     */
    public function launchProjet($id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Projet::class);
        // retrive the task
        $projet = $repo->findOneById($id);
      
        

        if($projet->getEtat() == 'Open'){
            $projet->setEtat('In Progress');
            $projet->setDateDebut(new \DateTime());
            $em->persist($projet);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_projet_index');
        }
       

        return $this->redirectToRoute('app_projet_show' , ['id' => $id]);
    }

    /**
     * @IsGranted("ROLE_OWNER")
     * @Route("/{id}/finish", name="app_projet_finish")
     */
    public function finishProjet($id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Projet::class);
        // retrive the task
        $projet = $repo->findOneById($id);
      
        

        if($projet->getEtat() == 'In Progress'){
            $projet->setEtat('Finished');
            $projet->setDateFin(new \DateTime());
            $em->persist($projet);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_projet_index');
        }
       

        return $this->redirectToRoute('app_projet_show' , ['id' => $id]);
    }


    /**
     * @IsGranted("ROLE_OWNER")
     * @Route("/{id}/cancel", name="app_projet_cancel")
     */
    public function cancelProjet($id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Projet::class);
        // retrive the task
        $projet = $repo->findOneById($id);
      
        if($projet->getEtat() != 'Finished'){
            $projet->setEtat('Cancelled');
            $projet->setDateFin(new \DateTime());
            $em->persist($projet);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_projet_index');
        }
       

        return $this->redirectToRoute('app_projet_show' , ['id' => $id]);
    }
}

