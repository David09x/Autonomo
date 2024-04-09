<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cliente>
 *
 * @method Cliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cliente[]    findAll()
 * @method Cliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    //    /**
    //     * @return Cliente[] Returns an array of Cliente objects
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

    //    public function findOneBySomeField($value): ?Cliente
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function anyadirCliente($nombre,$telefono){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "INSERT INTO cliente (nombre,telefono) VALUES (:nombre,:telefono)";
            $parameters = ['nombre' => $nombre,'telefono' => $telefono];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            $data  = 'OK';

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }

    public function buscarCliente($telefono){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT * FROM cliente WHERE telefono= :telefono";
            $parameters = ['telefono' => $telefono];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            //$data  = 'OK';

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }

    public function darIdCliente($telefono){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT * FROM cliente WHERE telefono= :telefono";
            $parameters = ['telefono' => $telefono];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            //$data  = 'OK';

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;

    }

    public function encontrarNombrePorId($id){
        $data = array();
        $connection = $this->getEntityManager()->getConnection();
        try {
            $body = "SELECT nombre FROM cliente WHERE id=:id";
            $parameters = ['id' => $id];

            $statement = $connection->executeQuery($body,$parameters);
            $results = $statement->fetchAll();

            $data =  $results;
            //$data  = 'OK';

        }catch(\Exception $e){
            $data = array('estado' => 'danger', 'mensaje' => $e->getMessage());
        }
        return $data;
    }
}
