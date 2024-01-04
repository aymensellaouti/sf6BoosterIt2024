<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    private $repository;
    public function __construct(private ManagerRegistry $managerRegistry)
    {
//        Récupération du manager pour les opérations de persistance (create, update et delete)
        $this->entityManager = $this->managerRegistry->getManager();
//        Récupération du répository pour les opérations de requétage de la base (read)
        $this->repository = $this->managerRegistry->getRepository(Product::class);
    }

    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        $product = new Product();
        $product->setName('Tv');
        $product->setQuantity(10);


        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
