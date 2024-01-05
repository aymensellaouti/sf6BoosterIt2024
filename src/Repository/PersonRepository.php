<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 *
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

//    /**
//     * @return Person[] Returns an array of Person objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Person
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     *
     * Retourne l'age moyen et le nombre de personnes
     * Dans un interval d'age passé en paramètre
     *
     * @param $minAge
     * @param $maxAge
     * @return array|null
     */
    public function statsAge($minAge, $maxAge): ?array
    {
        $qb =  $this->createQueryBuilder('p')
            ->select('avg(p.age) as ageMoyen, count(p.id) as nombreDePersonne');
            return $this->gePersonsInAgeInterval($qb, $minAge, $maxAge)
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     *
     * Retourne la liste des personnes dont l'age appartient à l'interval passé en paramètre
     *
     * @param $minAge
     * @param $maxAge
     * @return array|null
     */
    public function getPersonsByAge($minAge, $maxAge): ?array
    {
            $qb =  $this->createQueryBuilder('p');
            return $this->gePersonsInAgeInterval($qb, $minAge, $maxAge)
            ->orderBy('p.id', 'desc')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Ajoute à notre QueryBuilder un where permettant de sélectionner les personnes
     * Dans l'interval d'age passé en paramètre
     *
     * @param QueryBuilder $qb
     * @param $minAge
     * @param $maxAge
     * @return QueryBuilder
     */
    private function gePersonsInAgeInterval(QueryBuilder $qb, $minAge, $maxAge): QueryBuilder {
            return $qb->where('p.age >= :ageMin and p.age <= :ageMax')
                      ->setParameters(['ageMin'=> $minAge, 'ageMax' =>$maxAge]);
    }
}
