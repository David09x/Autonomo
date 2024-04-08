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

    //#[Route('/buscarCliente/{telefono}', name: 'buscar-cliente')]
    public function buscarClienteAntesDeAgregar(ManagerRegistry $doctrine, $telefono)
    {
        $buscarCliente = $doctrine->getRepository(Cliente::class)->buscarCliente($telefono);
        if(count($buscarCliente) > 0){
            $response = true;
            
        }else{
            $response = false;
           
        }

        return $response;
    }
    //#[Route('/buscarProveedor/{telefono}', name: 'buscar-Proveedor')]
    public function buscarProveedorAntesDeAgregar(ManagerRegistry $doctrine,$telefono){

        $buscarProveedor = $doctrine->getRepository(Proveedor::class)->buscarProveedor($telefono);
        if(count($buscarProveedor) > 0){
            $response = true;
            
            
        }else{
            $response =false;                       
        }

        return $response;
    }
    #[Route('/cliente/{nombre}/{telefono}', name: 'clientes-anyadir')]
    public function anyadirC(ManagerRegistry $doctrine, $nombre,$telefono): JsonResponse
    {

        $antesDeMeterBuscar = $this->buscarClienteAntesDeAgregar($doctrine,$telefono);
        
        if(!$antesDeMeterBuscar){
            
            $anyadirCliente =  $doctrine->getRepository(Cliente::class)->anyadirCliente($nombre,$telefono);
            if($anyadirCliente){

                $response = [
                'ok' => true,
                'descripcion' => 'Usuario agregado con exito'
                ];
            }else{
                $response = [
                    'ok' => false
                ];
            }  
        }else{
            $response = [
                'ok' => false,
                'descripcion' => 'Estas intentando agregar un usuario que tiene el mismo numero de telefono que otro usuario'
            ];
        }
        
        return new JsonResponse($response);
    }

    

    #[Route('/proveedor/{nombre}/{telefono}', name: 'proveedor-anyadir')]
    public function anyadirP(ManagerRegistry $doctrine, $nombre,$telefono): JsonResponse
    {

        $antesDeMeterBuscarP = $this->buscarProveedorAntesDeAgregar($doctrine,$telefono);
        if(!$antesDeMeterBuscarP){
            $anyadirProveedor =  $doctrine->getRepository(Proveedor::class)->anyadirProveedor($nombre,$telefono);
            if($anyadirProveedor){
                
            $response = [
                'ok' => true,
                'descripcion' => 'Proveedor agregado con exito'
                ];
            }else{
                $response = [
                    'ok' => false
                ];
            }  

        }else{
            $response = [
                'ok' => false,
                'descripcion' => 'Estas intentando agregar un usuario que tiene el mismo numero de telefono que otro usuario'
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
                'ok' => false
            ];
        }

        
        return new JsonResponse($response);
    }

    //#[Route('/fechaBuena/{fecha}', name: 'fecha')]
    public function obtenerFecha($fecha)
    {
        
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            
            $fecha_formateada = str_replace('-', '', $fecha);
            
            // Dividir la fecha en partes
            $partes_fecha = explode('-', $fecha_formateada);
            
            $anyo = substr($partes_fecha[0],0,4);
            $mes = substr($partes_fecha[0],4,2);
            $dia = substr($partes_fecha[0],6,2);

            $fecha_final = $anyo.$mes.$dia;
           
            
            
        } else {
            $fecha_final =  false;
        }

        $response = [
            'fecha' => $fecha_final
        ];
        
    
        return $response;
    } 

    #[Route('/mostrarCitasFecha/{fecha}', name: 'cita-dia')]
    public function mostrarCitas(ManagerRegistry $doctrine,$fecha): JsonResponse{

        $fechaBuena = $this->obtenerFecha($fecha);

        $citasBuscadas =   $doctrine->getRepository(Citas::class)->obtenerCitaFecha($fechaBuena['fecha']);

        if(count($citasBuscadas) > 0){

            $response = [
                'ok' => true,
                'citasEncontradas' => $citasBuscadas
            ];
        }else{
            
            $response = [
                'ok' => false
                
            ];
        }

        return new JsonResponse($response);

    }

    #[Route('/mostrarG/{fecha}/{fecha2}', name: 'mostrar-gastos')]
    public function mostrarGastos(ManagerRegistry $doctrine, $fecha,$fecha2): JsonResponse
    {
        $fechaBuena = $this->obtenerFecha($fecha);
        $fechaBuena2 = $this->obtenerFecha($fecha2);

        $gastos = $doctrine->getRepository(Gastos::class)->calcularGastos($fechaBuena['fecha'],$fechaBuena2['fecha']);

        if($gastos[0]['gastos'] != null){

            $response = [
                
                'gastos' => $gastos[0]['gastos']
            ];
        }else{
            $response = [
                'gastos' => 0
            ];
        }

        return new JsonResponse($response);
    }

    #[Route('/mostrarB/{fecha}/{fecha2}', name: 'mostrar-beneficios')]
    public function mostrarBeneficios(ManagerRegistry $doctrine, $fecha,$fecha2): JsonResponse
    {
        $fechaBuena = $this->obtenerFecha($fecha);
        $fechaBuena2 = $this->obtenerFecha($fecha2);

        $citas = $doctrine->getRepository(Servicios::class)->calcularBeneficios($fechaBuena['fecha'],$fechaBuena2['fecha']);

        if($citas[0]['beneficios'] !=  null){

            $response = [
    
                'beneficios' => $citas[0]['beneficios']
            ];
        }else {
            $response = [
                'beneficios' => 0
            ];
        }

        return new JsonResponse($response);
    }

}
