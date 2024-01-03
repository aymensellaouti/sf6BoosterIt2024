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
        //        Si on n'a pas le tableau de todo on va le créer et le mettre dans la session
        if (!$session->has('todos')) {
        //  On prépare le tableau de todo
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('infos', "Vous venez d'initialiser un tableau de todo");
//            $this->addFlash('infos', "Je vous assure, vous venez d'initialiser un tableau de todo");
        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    #[Route("todo/add/{name}/{content}", name:"app_todo_add")]
    public function addTodo(SessionInterface $session, $name, $content) {
        // 1- Vérifier que la session contient déjà les todos
        if (!$session->has('todos')) {
            // 1-1 Sinon
            // Ajouter un message flash pour informer que la liste n'est pas encore initialisée
            $this->addFlash('error', "La session n'est pas encore initialisée");
        } else {
            // 1-2 Si oui
            // 1-2-1 Vérifier l'existance du todo
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                //1-2-1-1 si oui flash erreur
                $this->addFlash('error', "Le todo de clé $name existe déjà");
            } else {
                //1-2-1-2 si non on l'ajoute + flash succèes
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo de clé $name a été ajouté avec succèes");
            }
        }
        //On réaffiche la liste des todos
        return $this->redirectToRoute('app_todo');
    }

    #[Route("todo/update/{name}/{content}", name:"app_todo_update")]
    public function updateTodo(SessionInterface $session, $name, $content) {
        // 1- Vérifier que la session contient déjà les todos
        if (!$session->has('todos')) {
            // 1-1 Sinon
            // Ajouter un message flash pour informer que la liste n'est pas encore initialisée
            $this->addFlash('error', "La session n'est pas encore initialisée");
        } else {
            // 1-2 Si oui
            // 1-2-1 Vérifier l'existance du todo
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                //1-2-1-1 si oui flash erreur
                $this->addFlash('error', "Le todo de clé $name n'existe pas");
            } else {
                //1-2-1-2 si non on la met à jour + flash succèes
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo de clé $name a été mis à jour avec succèes");
            }
        }
        //On réaffiche la liste des todos
        return $this->redirectToRoute('app_todo');
    }

    #[Route("todo/update/{name}", name:"app_todo_delete")]
    public function deleteTodo(SessionInterface $session, $name) {
        // 1- Vérifier que la session contient déjà les todos
        if (!$session->has('todos')) {
            // 1-1 Sinon
            // Ajouter un message flash pour informer que la liste n'est pas encore initialisée
            $this->addFlash('error', "La session n'est pas encore initialisée");
        } else {
            // 1-2 Si oui
            // 1-2-1 Vérifier l'existance du todo
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                //1-2-1-1 si oui flash erreur
                $this->addFlash('error', "Le todo de clé $name n'existe pas ");
            } else {
                //1-2-1-2 si non on le supprime + flash succèes
                unset($todos[$name]) ;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo de clé $name a été supprimé avec succèes");
            }
        }
        //On réaffiche la liste des todos
        return $this->redirectToRoute('app_todo');
    }
    #[Route("todo/reset", name:"app_todo_reset")]
    public function resetTodo(SessionInterface $session) {
        // 1- Vérifier que la session contient déjà les todos
        if (!$session->has('todos')) {
            // 1-1 Sinon
            // Ajouter un message flash pour informer que la liste n'est pas encore initialisée
            $this->addFlash('error', "La session n'est pas encore initialisée");
        } else {
            $session->remove('todos');
            $this->addFlash('success', "La session a été réinitialisée");
        }
        //On réaffiche la liste des todos
        return $this->redirectToRoute('app_todo');
    }
}
