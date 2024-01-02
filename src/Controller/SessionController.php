<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionInterface $session): Response
    {
//        si je suis dans la première visite j'affiche bienvnu
          if(!$session->has('nbVisite')) {
              $this->addFlash('info', 'C est votre première visite');
              $session->set('nbVisite',1);
              $message = "bienvenu";
          } else {
//        si je suis dans la néme visite j'affiche merci pour vote fidélité c'est votre néme visite'
              $nbVisite = $session->get('nbVisite') + 1;
              $message  = "merci pour vote fidélité c'est votre $nbVisite éme visite";
              $session->set('nbVisite',$nbVisite);
          }
        return $this->render('session/index.html.twig', [
            'message' => $message,
        ]);
    }
}
