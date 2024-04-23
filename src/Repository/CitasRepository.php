<?php

namespace App\Repository;

use App\Entity\Citas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Citas>
 *
 * @method Citas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citas[]    findAll()
 * @method Citas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citas::class);
    }

    //    /**
    //     * @return Citas[] Returns an array of Citas objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Citas
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function anyadirCita($idCliente,$idServicio,$hora,$fecha){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();

       
        try {
            $body = "INSERT INTO citas (idCliente,idServicio,hora,fecha) VALUES (:idCliente,:idServicio,:hora,:fecha)";
            $parameters = ['idCliente' => $idCliente,'idServicio' => $idServicio, 'hora' => $hora, 'fecha' => $fecha];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            $data  = 'OK';

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
            $data = $e->getMessage();
        }
        return $data;
    }

    public function obtenerCitaFecha($fecha)
    {
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT citas.id ,cliente.nombre, citas.hora ,  servicios.tipo , servicios.precio FROM citas INNER JOIN cliente ON cliente.id = citas.idCliente 
            INNER JOIN servicios ON servicios.id = citas.idServicio WHERE citas.fecha = :fecha ORDER BY citas.hora ASC";
            $parameters = ['fecha' => $fecha];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }

    public function comprobarCitaAntesDeAgregar($fecha,$hora){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT * FROM citas WHERE fecha = :fecha AND hora = :hora";
            $parameters = ['fecha' => $fecha,'hora' => $hora];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }
   
    public function mostrarCitaFechas($fecha,$fecha2)
    {
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT cliente.nombre, citas.hora , servicios.tipo , servicios.precio ,citas.fecha FROM citas INNER JOIN cliente ON cliente.id = citas.idCliente INNER JOIN servicios 
            ON servicios.id = citas.idServicio WHERE fecha BETWEEN :fecha AND :fecha2  ORDER BY CONCAT(citas.fecha, ' ', citas.hora) ASC";
            $parameters = ['fecha' => $fecha , 'fecha2' => $fecha2];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }

    public function borrarCita($id){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "DELETE FROM citas WHERE id = :id";
            $parameters = ['id' => $id ];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }
    
}
