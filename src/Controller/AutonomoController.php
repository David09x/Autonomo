<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;
use App\Entity\Proveedor;
use App\Entity\Gastos;
use App\Entity\Cliente;
use App\Entity\Servicios;
use App\Entity\Citas;
use App\Entity\Usuarios;

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

    #[Route('/citas/{idCliente}/{idServicio}/{hora}/{fecha}', name: 'cita-anyadir')]
    public function anyadirCita(ManagerRegistry $doctrine,$idCliente,$idServicio,$hora,$fecha): JsonResponse
    {
        $convertirFecha = $this->obtenerFecha($fecha);
        $anyadirCita =  $doctrine->getRepository(Citas::class)->anyadirCita($idCliente,$idServicio,$hora,$convertirFecha['fecha']);

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

    #[Route('/obtenerServicios', name: 'mostrar-Servicios')]
    public function mostrarServicios(ManagerRegistry $doctrine): JsonResponse{

        $servicios = $doctrine->getRepository(Servicios::class)->obtenerServicios();

       $response = [
                'servicios' => $servicios
            ];
        
        return new JsonResponse($response);
    }

    #[Route('/darClienteId/{telefono}', name: 'cliente-Id')]
    public function obtenerElIdCliente(ManagerRegistry $doctrine,$telefono): JsonResponse{

        $clienteIdBuscado = $doctrine->getRepository(Cliente::class)->darIdCliente($telefono);

        if(count($clienteIdBuscado) > 0){
            $response = [
                        'ok' => true,
                        'idDelCliente' => $clienteIdBuscado
                    ];

        }else{
            $response = [
                'ok' => false,
                'descripcion' => 'no existe el cliente'
            ];
        }
        
        return new JsonResponse($response);
    }

    #[Route('/buscarCitaPrevia/{hora}/{fecha}', name: 'mirar-cita-previa')]
    public function buscarCitaPrevia(ManagerRegistry $doctrine,$hora,$fecha): JsonResponse{
        $convertirFecha2 = $this->obtenerFecha($fecha);
        $citaP = $doctrine->getRepository(Citas::class)->comprobarCitaAntesDeAgregar($convertirFecha2['fecha'],$hora);
        
        if(count($citaP) > 0){
            $buscarNombrePorId2 = $doctrine->getRepository(Cliente::class)->encontrarNombrePorId($citaP[0]['idCliente']);
            $response = [
                        'ok' => false,
                        'citaPrevia' => $citaP,
                        
                        'descripcion' => "Ya hay una cita a esa hora y fecha de ".$buscarNombrePorId2[0]['nombre'],
                    ];

        }else{
            $response = [
                'ok' => true,
                'descripcion' => 'no hay cita'
            ];
        }
        
        return new JsonResponse($response);
    }

    #[Route('/mostrarProveedoresLista', name: 'buscar-proveedores')]
    public function mostrarProveedores(ManagerRegistry $doctrine){
        $Proveedores= $doctrine->getRepository(Proveedor::class)->mostrarProveedores();

        $response = [
                 'Proveedores' => $Proveedores
             ];
         
         return new JsonResponse($response);
    }

    #[Route('/agregarGastos/{idProveedor}/{descripcion}/{precio}/{fecha}' , name: 'agregar-gastos')]
    public function agregarGastos(ManagerRegistry  $doctrine,$idProveedor,$descripcion,$precio,$fecha): JsonResponse{
        $convertirFecha2 = $this->obtenerFecha($fecha);
        $gastos = $doctrine->getRepository(Gastos::class)->agregarGastos($idProveedor,$descripcion,$precio, $convertirFecha2['fecha']);

        if($gastos == "ok"){
            $response = [
                'status' => "se agrego",
                'convertirFecha2' => $convertirFecha2
            ];
        }else{
            $response = [
                'status' => "no se agrego",
                'convertirFecha2' => $convertirFecha2
            ];
        }

        return new JsonResponse($response);
    }

    #[Route('/mostrarGastosFechas/{fecha}/{fecha2}', name: 'mostrar-gastos-fechas')]
    public function mostrarGastosFecha(ManagerRegistry $doctrine,$fecha,$fecha2): JsonResponse{
        $convertirFecha = $this->obtenerFecha($fecha);
        $convertirFecha2 = $this->obtenerFecha($fecha2);
        
        $obtenerGastos = $doctrine->getRepository(Gastos::class)->buscarGastos($convertirFecha['fecha'], $convertirFecha2['fecha']);

        
        if(count($obtenerGastos) !=  null){

            $response = [
                'ok' => true,
                'gastos' => $obtenerGastos
            ];
        }else{
            $response = [
                'ok' => false,
                'convertirFecha2' => $obtenerGastos
            ];
        }

        return new JsonResponse($response);
    }

    #[Route('/mostrarBeneficiosFechas/{fecha}/{fecha2}', name: 'mostrar-beneficios-fechas')]
    public function mostrarBeneficiosFecha(ManagerRegistry $doctrine,$fecha,$fecha2): JsonResponse{
        $convertirFecha = $this->obtenerFecha($fecha);
        $convertirFecha2 = $this->obtenerFecha($fecha2);
        

        $obtenerBeneficios = $doctrine->getRepository(Citas::class)->mostrarCitaFechas($convertirFecha['fecha'], $convertirFecha2['fecha']);
        
        if(count($obtenerBeneficios) > 0){

            $response = [
                'ok' => true,
                'beneficios' => $obtenerBeneficios
            ];
        }else{
            $response = [
                'ok' => false,
                'convertirFecha2' => $obtenerBeneficios
            ];
        }

        return new JsonResponse($response);
    }

    #[Route('/borrarCita/{id}', name: 'borrar-Cita')]
    public function borrarCitaCitada(ManagerRegistry  $doctrine,$id): JsonResponse{

       $doctrine->getRepository(Citas::class)->borrarCita($id);

        $response = "se borro la cita";

        return new JsonResponse($response);

    }

    #[Route('/crearToken', name: 'crear-token')]
    public function crearToken(ManagerRegistry  $doctrine): JsonResponse{
        $caracteres = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '@', '#', '?', '¿', '!', '¡'];

        $longitud = count($caracteres);
        $token = '';

      
        for ($i = 0; $i < 30; $i++) {
        $indice = rand(0, $longitud - 1);
        $token .= $caracteres[$indice];
        }

        return new JsonResponse(['token' => $token]);

    }

    
    #[Route('/buscar-usuario', name: 'buscar-usuario', methods: ['POST'])]
public function buscarUsuario(Request $request,ManagerRegistry $doctrine): JsonResponse
{

    $content = $request->getContent();
    $data = json_decode($content, true);
    $idUsuario = $data['idUsuario'];
    $password = $data['password'];
    $usuario = $doctrine->getRepository(Usuarios::class)->buscarUsuario($idUsuario, $password);

    if($usuario){
        $response = [
            'status' => true,
            'token' => $usuario[0]['token']
        ];
    }else{
        $response = [
            'status' => false,
            'descripcion' => "credenciales inválidas"
        ];
    }

    return new JsonResponse($response);
}


}
