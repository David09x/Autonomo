<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;
use App\Entity\Proveedor;
use App\Entity\Gastos;
use App\Entity\Cliente;
use App\Entity\Servicios;
use App\Entity\Citas;

class AutonomoController extends AbstractController
{
    //#[Route('/restaurant', name: 'app_restaurant')]
    /*public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RestaurantController.php',
        ]);
    }*/
    #[Route('/restaurant', name: 'app_restaurant')]
    public function prueba1(ManagerRegistry $doctrine): JsonResponse
    {
        $categorias =  $doctrine->getRepository(Citas::class)->findAll();
        $arrayRest= [];
        if(count($categorias) > 0){
            foreach($categorias as $cate){
                $arrayRest [] = $cate->__toArray();
            }
        }else{
            $response = 'no hay nada';
        }

        $response = [
            'categorias' => $arrayRest
        ];
        
        return new JsonResponse($response);
    }

    #[Route('/cliente/{nombre}/{telefono}', name: 'clientes-anyadir')]
    public function anyadirC(ManagerRegistry $doctrine, $nombre,$telefono): JsonResponse
    {
        $anyadirCliente =  $doctrine->getRepository(Cliente::class)->anyadirCliente($nombre,$telefono);

        if($anyadirCliente){

        $response = [
            'ok' => true
        ];
        }else{
            $response = [
                'ok' => false
            ];
        }

        
        return new JsonResponse($response);
    }

    #[Route('/proveedor/{nombre}/{telefono}', name: 'proveedor-anyadir')]
    public function anyadirP(ManagerRegistry $doctrine, $nombre,$telefono): JsonResponse
    {
        $anyadirProveedor =  $doctrine->getRepository(Proveedor::class)->anyadirProveedor($nombre,$telefono);

        if($anyadirProveedor){

        $response = [
            'ok' => true
        ];
        }else{
            $response = [
                'ok' => false
            ];
        }

        
        return new JsonResponse($response);
    }

    #[Route('/citas/{idCliente}/{idServicio}', name: 'cita-anyadir')]
    public function anyadirCita(ManagerRegistry $doctrine,$idCliente,$idServicio): JsonResponse
    {
        $anyadirCita =  $doctrine->getRepository(Citas::class)->anyadirCita($idCliente,$idServicio);

        if($anyadirCita){

        $response = [
            'ok' => $anyadirCita
        ];
        }else{
            $response = [
                'ok' => $anyadirCita
            ];
        }

        
        return new JsonResponse($response);
    }

}
