<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstController
{
//    Pour exécuter la méthode first de notre FirstController il
//    faut appeler l'uri /first
    #[Route('/first', name: 'app_first')]
    public function first(): Response {
        $response = new Response('<h1>Bonjour BoosterIT</h1>');
        return $response;
    }
}