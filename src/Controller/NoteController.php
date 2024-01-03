<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    #[Route('/note/{count<\d+>?5}', name: 'app_note')]
    public function index($count): Response
    {
        $notes = [];
        for ($i = 0; $i < $count; $i++) {
            $notes[] = random_int(0,20);
        }
        return $this->render('note/index.html.twig', [
            'notes' => $notes,
        ]);
    }
}
