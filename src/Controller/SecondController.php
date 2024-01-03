<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecondController extends AbstractController
{
    #[Route('/second', name: 'app_second')]
    public function index(): Response
    {
        return $this->render('second/index.html.twig', [
            'controller_name' => 'SecondController',
        ]);
    }
    #[Route("/second/request", name:"app_test_request")]
    public function request(Request $request): Response {
        dd($request);
    }

//    Pour créer une fonctionnalité avec Symfony
//    1- Créer une méthode dans une classe Controller
//    2- Créer une route pour déclancher la méthode
//    3- Si on a une vue on crée une page twig dans le dossier templates

    #[Route("/second/{param}/{param2}", name:"app_param")]
    public function showParam($param, $param2): Response{
        dd($param, $param2);
    }

    #[Route("/second/{name}", name:"app_bonjour")]
    public function param(Request $request, $name): Response {
        $groupe = $request->query->get('groupe');
        return $this->render('first/param.html.twig', [
            'name' => $name,
            'groupe' => $groupe,
        ]);
    }

    #[Route("/cv/{name?garban}/{firstname?Matthieu}/{age<\d+>?44}/{section?booster}", name:"app_cv")]
    public function cv($name, $firstname, $age, $section): Response {

        return $this->render('first/cv.html.twig', [
            'name' => $name,
            'firstname' => $firstname,
            'age' => $age,
            'section' => $section,
        ]);
    }
}
