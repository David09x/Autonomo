<?php

namespace App\Repository;

use App\Entity\Servicios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Servicios>
 *
 * @method Servicios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Servicios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Servicios[]    findAll()
 * @method Servicios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiciosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Servicios::class);
    }

    //    /**
    //     * @return Servicios[] Returns an array of Servicios objects
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

    //    public function findOneBySomeField($value): ?Servicios
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function calcularBeneficios($fecha,$fecha2){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT SUM(servicios.precio) beneficios FROM servicios INNER JOIN citas ON citas.idServicio = servicios.id WHERE citas.fecha BETWEEN :fecha AND :fecha2;";
            $parameters = ['fecha' => $fecha ,  'fecha2' => $fecha2];
            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            
        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    
    }

    public function obtenerServicios(){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT * FROM servicios";
            $parameters = [];
            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            
        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }
}
