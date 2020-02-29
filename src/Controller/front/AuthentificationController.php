<?php


namespace App\Controller\front;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{


    /**
     * @Route("/connexion" , name="connexion")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $user=$this->getUser();
        if(isset($user))
        {
            return $this->redirectToRoute('home');
        }
        $lasteUsername=$utils->getLastUsername();
        $error=$utils->getLastAuthenticationError();
        return $this->render('formulaire/login.html.twig',[
            'lastUsername'=>$lasteUsername,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/deconnexion", name="deconneion")
     */
    public function logout(){
    }
}