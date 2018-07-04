<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 11/6/18
 * Time: 6:33 PM
 */

namespace AppBundle\Controller\Usuario;


use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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






    //editar usuario

    /**
     * @Route("/usuario/{id}", options={"expose"=true}, name="edit_usuario")
     * @Method("GET")
     * @param Usuario $usuario
     * @return Response
     */
    public function indexEditUsuario(Usuario $usuario){

        return $this->render('@App/Usuario/editar_usuario.html.twig', [
            'usuario' => $usuario
        ]);
    }





    //API Rest

    /**
     * @Route("rest/usuario", options={"expose"=true}, name="listar_usuarios")
     * @Method("GET")
     * @return JsonResponse
     */
    public function listarUsuarios(){

        $usuarios=$this->getDoctrine()->
        getRepository(Usuario::class)
            ->findAll();
        $helpers=$this->get("app.helpers");
        return new JsonResponse($helpers->json($usuarios));
    }

    /**
     * @Route("rest/usuario/{id}", options={"expose"=true}, name="buscar_usuario")
     * @Method("GET")
     * @param Usuario $usuario
     */
    public function buscarUsuario(Usuario $usuario)
    {
        $helpers=$this->get("app.helpers");
        return new JsonResponse($helpers->json($usuario));
    }

    /**
     * @Route("/rest/usuario", options={"expose"=true}, name="guardar_usuario")
     * @Method("POST")
     */
    public function guardarUsuario(Request $request)
    {
        $data=$request->getContent();

        $data=(json_decode($data,true));
        $usuario=new Usuario();
        $form=$this->createForm(UsuarioType::class,$usuario);
        $form->submit($data);
      //  $usuario->setNombre($data["nombre"]);
       // $usuario->setUsername($data["username"]);

        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            $helpers =$this->get("app.helpers");
            return new JsonResponse($helpers->json($usuario));
        }
       // $form->getErrors();
        return new JsonResponse(null,400);
    }

    /**
     * @Route("/rest/usuario/{id}", options={"expose"=true},name="actualizar_usuario")
     * @Method("PUT")
     * @param Request $request
     * @param Usuario $usuario
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,Usuario $usuario){
        $data=$request->getContent();
        $data=(json_decode($data,true));
        $form=$this->createForm(UsuarioType::class,$usuario);
        $form->submit($data);
        //$usuario->setNombre($data["nombre"]);
       // $usuario->setUsername($data["username"]);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $helpers =$this->get("app.helpers");
            //mismo metodo que el anterior pero usando el servicios de simfony
            //$jsonContent=$this->get('serializer')->serializer($usuario,'json');

            //$jsonContent=json_decode($jsonContent,true);
            return new JsonResponse($helpers->json($usuario));
        }
        //$form->getErrors();
        return new JsonResponse(null,400);
    }

    //eliminar usuario
    /**
     * @Route("/rest/usuario/{id}", options={"expose"=true}, name="eliminar_usuario")
     * @Method("DELETE")
     * @param Usuario $usuario
     * @return Response
     */
    public function indexEliminarUsuario(Usuario $usuario){
        $em = $this->getDoctrine()->getManager();
        $em->remove($usuario);
        $em->flush();
        return $this->redirectToRoute('users');
    }
}