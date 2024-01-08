<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Service\UploadService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        $this->repository = $this->managerRegistry->getRepository(Person::class);
    }
    #[Route('/list/{ageMin?0}/{ageMax?200}', name: 'app_person')]
    public function index($ageMin, $ageMax): Response
    {
//        Récupérer les personnes dans la base de données
        $persons = $this->repository->getPersonsByAge($ageMin, $ageMax);
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }
    #[Route('/detail/{id}', name: 'app_person_detail')]
    public function detail(Person $person = null): Response
    {
        if(!$person) {
            throw new NotFoundHttpException("La personne n'existe pas");
        }
        return $this->render('person/details.html.twig', [
            'person' => $person,
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

    #[Route('/edit/{id?0}', name: 'app_person_add_form')]
    public function addForm(Person $person = null, Request $request, UploadService $uploadService): Response
    {
        if (!$person) {
            $person = new Person();
        }
//          1- Créer le formulaire
          $form = $this->createForm(PersonType::class, $person);
//          $form->remove('createdAt');
//          $form->remove('updatedAt');
          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()) {
              /** @var UploadedFile $path */
              $path = $form->get('image')->getData();
              if ($path) {
                  $directory = $this->getParameter('person_directory');
                  $newFilename = $uploadService->uploadFile($path, $directory);
                  $person->setImage($newFilename);
              }

              $this->entityManager->persist($person);
              $this->entityManager->flush();
              return $this->redirectToRoute('app_person');
          } else {
              return $this->render('person/addForm.html.twig', [
                  'form' => $form->createView(),
              ]);
          }
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
    #[Route('/delete/{person}', name: 'app_person_delete')]
    public function delete(Person $person = null): Response
    {
        if(!$person) {
            throw new NotFoundHttpException("La person n'existe pas");
        }

        //     Je met l'opération de suppression dans la transaction
        $this->entityManager->remove($person);
        //        Exécuter la transaction
        $this->entityManager->flush();
        return new Response('<h1>Personne supprimé avec succès</h1>');
    }
    #[Route('/stats/{ageMin?0}/{ageMax?200}', name: 'app_stats_person')]
    public function stats($ageMin, $ageMax): Response
    {
//        Récupérer les personnes dans la base de données
        $stats = $this->repository->statsAge($ageMin, $ageMax);

        return $this->render('person/stats.html.twig', [
            'stats' => $stats[0],
        ]);
    }
}
