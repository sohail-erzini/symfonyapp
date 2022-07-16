<?php

namespace App\Controller;

use App\Entity\Phase;
use App\Entity\Projet;
use App\Form\PhaseType;
use App\Repository\PhaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/phase")
 */
class PhaseController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_MANAGER') or is_granted('ROLE_OWNER') or is_granted('ROLE_DEV')")
     * @Route("/", name="app_phase_index", methods={"GET"})
     */
    public function index(PhaseRepository $phaseRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('phase/index.html.twig', [
            'phases' => $phaseRepository->findAll(),
        ]);
    }

    /**
     * @Security("is_granted('ROLE_MANAGER') or is_granted('ROLE_OWNER')")
     * @Route("/new", name="app_phase_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PhaseRepository $phaseRepository ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
    
        $phase = new Phase();
        $form = $this->createForm(PhaseType::class, $phase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phase->setStatus('Open');
            $phaseRepository->add($phase, true);

            return $this->redirectToRoute('app_phase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phase/new.html.twig', [
            'phase' => $phase,
            'form' => $form,
        ]);
    }

    /**
     * @Security("is_granted('ROLE_MANAGER') or is_granted('ROLE_OWNER') or is_granted('ROLE_DEV')")
     * @Route("/{id}", name="app_phase_show", methods={"GET"})
     */
    public function show(Phase $phase): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $phaseTasks = $phase->getTaches()->getValues();
        
        return $this->render('phase/show.html.twig', [
            'phase' => $phase,
            'phaseTasks' => $phaseTasks
        ]);
    }

    /**
     * @Security("is_granted('ROLE_MANAGER') or is_granted('ROLE_OWNER')")
     * @Route("/{id}/edit", name="app_phase_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Phase $phase, PhaseRepository $phaseRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(PhaseType::class, $phase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phaseRepository->add($phase, true);

            return $this->redirectToRoute('app_phase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phase/edit.html.twig', [
            'phase' => $phase,
            'form' => $form,
        ]);
    }

    /**
     * @Security("is_granted('ROLE_MANAGER') or is_granted('ROLE_OWNER')")
     * @Route("/{id}", name="app_phase_delete", methods={"POST"})
     */
    public function delete(Request $request, Phase $phase, PhaseRepository $phaseRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$phase->getId(), $request->request->get('_token'))) {
            $phaseRepository->remove($phase, true);
        }

        return $this->redirectToRoute('app_phase_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Security("is_granted('ROLE_MANAGER')")
     * @Route("/{id}/launch", name="app_phase_launch")
     */
    public function launchPhase($id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Phase::class);
        // retrive the task
        $phase = $repo->findOneById($id);
      
        if($phase->getStatus() == 'Open'){
            $phase->setStatus('In Progress');
            $phase->setDateDebut(new \DateTime());
            $em->persist($phase);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_phase_show' , ['id' => $id]);
        }
       

        return $this->redirectToRoute('app_phase_show' , ['id' => $id]);
    }

    /**
     * @Security("is_granted('ROLE_MANAGER')")
     * @Route("/{id}/finish", name="app_phase_finish")
     */
    public function finishPhase($id , EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repo = $em->getRepository(Phase::class);
        // retrive the task
        $phase = $repo->findOneById($id);
      
        if($phase->getStatus() == 'In Progress'){
            $phase->setStatus('Finished');
            $phase->setDateFin(new \DateTime());
            $em->persist($phase);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('app_phase_show' , ['id' => $id]);
        }
       
        return $this->redirectToRoute('app_phase_show' , ['id' => $id]);
       
    }
}