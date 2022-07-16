<?php

namespace App\Controller;

use App\Entity\Livrable;
use App\Entity\Tache;
use App\Form\LivrableType;
use App\Repository\LivrableRepository;
use App\Repository\TacheRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as SecurityExtra;

class LivrableController extends AbstractController
{
    /**
     * @SecurityExtra("is_granted('ROLE_DEV')")
     * @Route("{id}/livrable/new", name="app_livrable_new")
     */
    public function new(Request $request,$id,  SluggerInterface $slugger, Livrable $livrable=null,ManagerRegistry $doctrine):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $livrable = new Livrable();
        $form = $this->createForm(LivrableType::class, $livrable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $DocFile */
            $DocFile = $form->get('DocFile')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($DocFile) {
                $originalFilename = pathinfo($DocFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$DocFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $DocFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $livrable->setDocFile($newFilename);
                //AELH Add id test
                $liv = $this->getDoctrine()->getRepository(Tache::class)->find($id);
                if(!$liv){
                    throw $this->createNotFoundException('Ko');
                }
                $livrable->setTache($liv);
            }
            $doctrine->getManager()->persist($livrable);
            $doctrine->getManager()->flush();



            // ... persist the $product variable or any other work

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('livrable/index.html.twig', [
            'form' => $form,
        ]);
    }
    //
    /**
     * @SecurityExtra("is_granted('ROLE_DEV')")
     * @Route("/livrable/{id}", name="app_livrable_delete", methods={"POST"})
     */
    public function delete(Request $request, Livrable $livrable, LivrableRepository $livrableRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$livrable->getId(), $request->request->get('_token'))) {
            $livrableRepository->remove($livrable, true);
        }

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }


}
