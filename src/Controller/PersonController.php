<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('person')]
class PersonController extends AbstractController
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
    #[Route('/', name: 'app_person')]
    public function index(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

    #[Route('/add/{name}/{firstname}/{age}', name: 'app_person_add')]
    public function add($name, $firstname, $age): Response
    {
        $person = new Person();
        $person->setName($name);
        $person->setFirstName($firstname);
        $person->setAge($age);
//        J'ajoute l'opération dans la transaction
        $this->entityManager->persist($person);

        $person1 = new Person();
        $person1->setName($name.'2');
        $person1->setFirstName($firstname.'2');
        $person1->setAge($age);
        $this->entityManager->persist($person1);
//        Exécuter la transaction
        $this->entityManager->flush();
        return $this->render('person/details.html.twig', [
            'person' => $person,
        ]);
    }

    #[Route('/update/{person}/{name}/{firstname}/{age}', name: 'app_person_update')]
    public function update(Person $person = null,$name, $firstname, $age): Response
    {
        if(!$person) {
            throw new NotFoundHttpException("La person n'existe pas");
        }
        $person->setName($name);
        $person->setFirstName($firstname);
        $person->setAge($age);
        //        J'ajoute l'opération dans la transaction
        $this->entityManager->persist($person);
        //        Exécuter la transaction
        $this->entityManager->flush();
        return $this->render('person/details.html.twig', [
            'person' => $person,
        ]);
    }

}
