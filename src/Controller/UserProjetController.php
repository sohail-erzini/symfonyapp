<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projet;
use App\Entity\User;
use App\Entity\UserProjet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserProjetController extends AbstractController
{
    /**
     * @Route("/projet/{id}/addemploye", name="app_user_projet_assoc")
     */
    public function associateEmploye(Request $request , EntityManagerInterface $em , $id): Response
    {
        // retrieve the project
        $repo = $em->getRepository(Projet::class);
        $projet = $repo->findOneById($id);

        // dd($projet);

        $form = $this->createFormBuilder()
            
            ->add('Employe', EntityType::class, [
            // looks for choices from this entity
            'class' => User::class,
        
            // uses the user.username property as the visible option string
            'choice_label' => 'username',
        
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
            ])
            ->add('role' , TextType::class ,[
                'attr' => ['placeholder' => 'MANAGER OR DEV'],
            ])
            ->getForm()
        ;

        $form->handleRequest($request);
        //verification de la soumission et de la validite des infos
        if($form->isSubmitted() && $form->isValid()){

            // retrieve submitted form data ( user and role)
            $data = $form->getData();
            
            // retrieve Employe
            $employe = $data['Employe'];
            $employe_role = $data['role'];

            // set user/employe role in user table to the submitted role
            if ($employe_role == "MANAGER"){
                $employe->setRoles(array('ROLE_MANAGER'));
            }
            elseif($employe_role == "DEV"){
                $employe->setRoles(array('ROLE_DEV'));
            }

            // dd($employe);

            // set UserProjet association relations , save changes to db
            $userProjet = new UserProjet();
            $userProjet->setRoleInProjet($employe_role);
            $userProjet->setProjet($projet);
            $userProjet->setUser($employe);

            $em->persist($employe);
            $em->persist($userProjet);

            $em->flush();

            return $this->redirectToRoute('app_projet_index'  
            );



        }

        return $this->render('projet/associerEmployee.html.twig' , ['AssocEmployeForm' => $form->createView()
    ]);
    }
}
