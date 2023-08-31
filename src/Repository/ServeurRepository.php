<?php

namespace App\Repository;

use App\Entity\Serveur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serveur>
 *
 * @method Serveur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serveur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serveur[]    findAll()
 * @method Serveur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serveur::class);
    }

    public function getServersByName(string $name){
        $sql="select * from serveur inner join site on site.id_serveur=serveur.id where serveur.name like '%".$name."%'";
        $conn = $this->getEntityManager()->getConnection();
        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }
    public function getServersByIp(string $ip){
        $sql="select * from serveur inner join site on site.id_serveur=serveur.id where  serveur.ipaddress like '%".$ip."%'";
        $conn = $this->getEntityManager()->getConnection();
        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Serveur[] Returns an array of Serveur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Serveur
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
