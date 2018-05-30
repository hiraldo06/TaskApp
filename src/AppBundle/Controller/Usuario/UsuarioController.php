<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 11/6/18
 * Time: 6:33 PM
 */

namespace AppBundle\Controller\Usuario;


use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UsuarioController extends Controller
{
    /**
     * @Route("/usuario", name="users")
     */
    public function indexUsuario(){

        /*$em=$this->getDoctrine()->getManager();

        $usuario=new Usuario();
        $usuario->setNombre("Ivan Mendoza");
        $usuario->setUsername("ivanm@gmail.com");

        $em->persist($usuario);
        $em->flush();
        dump( $usuario);
        die;*/

        $usuarios=$this->getDoctrine()->
        getRepository(Usuario::class)
        ->findAll();

        return $this->render('@App/Usuario/lista.html.twig', [
            'usuarios' => $usuarios
        ]);


    }


    /**
     * @Route("/usuario/{idUsuario}", name="informacion_usuario")
     */
    public function indexUsuarioInfo($idUsuario){
        /*dump( "aqui estamos con el id del usario : ".$idUsuario);
        die;*/
        return $this->render('@App/Usuario/index.html.twig', [
            'idUsuario' => $idUsuario
        ]);
    }


    //API Rest

    /**
     * @Route("/rest/usuario", name="buscar_usuarios")
     * @Method("GET")
     */
    public function buscarUsuarios(Request $request){
        return null;
    }

    /**
     * @Route("rest/usuario/{id}", name="buscar_usuario")
     * @Method("GET")
     * @ParamConverter("usuario", class="AppBundle:Usuario")
     * @param Usuario $usuario
     */
    public function buscarUsuario($usuario)
    {
        $helpers=$this->get("app.helpers");
        return new JsonResponse($helpers->json($usuario));
    }

    /**
     * @Route("/rest/usuario", name="guardar_usuario")
     * @Method("POST")
     */
    public function guardarUsuario(Request $request)
    {
        $data=$request->getContent();

        $data=(json_decode($data,true));
        $usuario=new Usuario();
        $usuario->setNombre($data["nombre"]);
        $usuario->setUsername($data["username"]);

        $em=$this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();
        $helpers =$this->get("app.helpers");
        return new JsonResponse($helpers->json($usuario));
    }

    /**
     * @Route("/rest/usuario/{id}", name="actualizar_usuario")
     * @Method("PUT")
     * @ParamConverter("usuario", class="AppBundle:Usuario")
     * @param Request $request
     * @param Usuario $usuario
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,$usuario){
        $data=$request->getContent();
        $data=(json_decode($data,true));
        $em=$this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse($data);
    }
}