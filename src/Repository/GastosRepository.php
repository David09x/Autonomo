<?php

namespace App\Repository;

use App\Entity\Gastos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gastos>
 *
 * @method Gastos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gastos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gastos[]    findAll()
 * @method Gastos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GastosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gastos::class);
    }

    //    /**
    //     * @return Gastos[] Returns an array of Gastos objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Gastos
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function calcularGastos($fecha,$fecha2){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT SUM(precio) gastos FROM gastos WHERE fecha BETWEEN :fecha AND :fecha2; ";
            $parameters = ['fecha' => $fecha,'fecha2' => $fecha2];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }

    public function agregarGastos($idProveedor,$descripcion,$precio,$fecha){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "INSERT INTO gastos (idProveedor,descripcion,precio,fecha) VALUES (:idProveedor,:descripcion,:precio,:fecha)";
            $parameters = ['idProveedor' => $idProveedor,'descripcion' => $descripcion,'precio' => $precio,'fecha' => $fecha];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            $data = "ok";

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }

    public function buscarGastos($fecha,$fecha2){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT proveedor.nombre ,descripcion,precio,fecha FROM `gastos` inner JOIN proveedor
             WHERE gastos.idProveedor = proveedor.id AND fecha BETWEEN :fecha AND :fecha2  ORDER BY fecha ASC";
            $parameters = ['fecha' => $fecha,'fecha2' => $fecha2];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;

    }
}
