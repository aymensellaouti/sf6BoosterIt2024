<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeritageController extends AbstractController
{
    #[Route('/heritage', name: 'app_heritage')]
    public function index(): Response
    {
        return $this->render('heritage/index.html.twig');
    }
}
