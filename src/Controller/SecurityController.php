<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }




    /**
     * @Route("/registration", name="security_registration")
     */

    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder )
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash =$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            // $user->setRoles(array('ROLE_OWNER'));

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig',
        [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route ("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');

    }

    /**
     * @Route ("/logout", name="security_logout")
     */

    public function logout()
    {

    }

    /**
     * @Route ("/profile", name="security_profile")
     */
    public function profile():Response
    {
         // returns User object or null if not authenticated
        $user = $this->security->getUser();
            if($user == null){

            return $this->redirectToRoute('security_login');
            }
        
        
        return $this->render('security/profile.html.twig' , [
            'user' => $user
        ]);
    }

    /**
     * @Route ("/profile/{id}/edit", name="security_profile_edit")
     */
    public function editProfile(Request $request , $id , EntityManagerInterface $manager , UserPasswordEncoderInterface $encoder):Response
    {
        $userloggedIn = $this->security->getUser();
        $userloggedInId = $userloggedIn->getId();
         if($id != $userloggedInId) {
            return $this->redirectToRoute('security_login');
         }
            $repo = $manager->getRepository(User::class);

            $user = $repo->find($id);
            // dd($user);
            $form = $this->createFormBuilder($user)
                ->add('Username', TextType::class)
                ->add('Email' , EmailType::class )
                ->add('Password', PasswordType::class)
                ->add('confirm_password' , PasswordType::class )
                ->add('LastName' , TextType::class)
                ->add('FirstName' , TextType::class)
                ->add('tel' , TextType::class)
                ->add('DateEmbauche' , TextType::class)
                ->add('Sexe' , TextType::class , [
                    'attr' => ['placeholder' => 'M or F']
                ])
                ->add('Nationalite' , TextType::class)
                ->add('Matricule' , TextType::class)
                ->getForm()
            ;

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // retrive submitted user data
                $data = $form->getData();
                
                // encrypt the submitted user password and set it to user object
                $hash =$encoder->encodePassword($user, $data->getPassword());
                $user->setPassword($hash);

                // set other fields 
                $user->setUsername($data->getUsername());
                $user->setEmail($data->getEmail());
                $user->setFirstName($data->getFirstName());
                $user->setLastName($data->getLastName());
                $user->setDateEmbauche($data->getDateEmbauche());
                $user->setMatricule($data->getMatricule());
                $user->setNationalite($data->getNationalite());
                $user->setSexe($data->getSexe());
                $user->setTel($data->getTel());
                // dd($user);

                $manager->persist($user);
                $manager->flush();
                
                return $this->redirectToRoute('security_profile');
            } 
      
        return $this->render('security/editProfile.html.twig' , ['editProfileForm' => $form->createView()]);
    }
}
