<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {
        //        Si on n'a le tableau de todo on va le créer et les mettre dans la session
        if (!$session->has('todos')) {
        //  On prépare le tableau de todo
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('infos', "Vous venez d'initialiser un tableau de todo");
            $this->addFlash('infos', "Je vous assure, vous venez d'initialiser un tableau de todo");
        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }
}
