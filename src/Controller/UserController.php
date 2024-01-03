<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $users = [
            ['firstname' => 'aymen', 'name' => 'sellaouti', 'age' => 41],
            ['firstname' => 'Nicolas', 'name' => 'Brunet', 'age' => 22],
            ['firstname' => 'Clement', 'name' => 'Serizay', 'age' => 19]
        ];
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
