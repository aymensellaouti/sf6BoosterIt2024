<?php

namespace App\Controller;

use App\Service\FirstService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstController extends AbstractController
{
//    Pour exécuter la méthode first de notre FirstController il
//    faut appeler l'uri /first
    #[Route('/', name: 'app_home')]
    public function home(FirstService $firstService): Response {
        $randomMessage = $firstService->getRandomString(10);
        return new Response("<h1>Bonjour BoosterIT, voila une chaine aléatoire : $randomMessage</h1>");
    }

    #[Route("/first", name: 'app_first')]
    public function first(): Response {
        $response = new Response('<h1>Bonjour BoosterIT</h1>');
        return $response;
    }
}