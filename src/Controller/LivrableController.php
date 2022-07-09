<?php

namespace App\Controller;

use App\Entity\Livrable;
use App\Form\LivrableType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class LivrableController extends AbstractController
{
    /**
     * @Route("/livrable/new", name="app_livrable_new")
     */
    public function new(Request $request, SluggerInterface $slugger, Livrable $livrable=null,ManagerRegistry $doctrine):Response
    {
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

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $livrable->setDocFile($newFilename);
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
}
