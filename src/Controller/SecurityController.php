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
}
