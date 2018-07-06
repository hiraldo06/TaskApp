<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 7/7/18
 * Time: 8:38 AM
 */

namespace AppBundle\Controller\Usuario;


use AppBundle\AppBundle;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioRestController extends Controller
{
    //API Rest

    /**
     * @Route("rest/usuario", options={"expose"=true}, name="listar_usuarios")
     * @Method("GET")
     * @return Response
     */
    public function listarUsuarios(){

        $usuarios=$this->getDoctrine()->
        getRepository(Usuario::class)
            ->findAll();

        dump($usuarios);
        die();
        //$jsonContent=$this->get('serializer')->serialize($usuarios,'json');

        //$jsonContent=json_decode($jsonContent,true);
        $helpers=$this->get(Helpers::class);
        return $helpers->json2($usuarios);
    }

    /**
     * @Route("rest/usuario/roles", options={"expose"=true}, name="rest_rolest_usuario")
     * @Method("GET")
     * @return Response
     */
    public function buscarByRoleUsuario()
    {
        $usuario=$this->getDoctrine()->getRepository(Usuario::class)
            ->findByRolesUsuario("ROLE_TECNICO");
        $helpers=$this->get(Helpers::class);
        return $helpers->json2($usuario);
    }
    /**
     * @Route("rest/usuario/{id}", options={"expose"=true}, name="buscar_usuario")
     * @Method("GET")
     * @param Usuario $usuario
     */
    public function buscarUsuario(Usuario $usuario)
    {
        $helpers=$this->get(Helpers::class);
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

        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $user_repo=$em->getRepository('AppBundle:Usuario');
            $user=$user_repo->findOneBy(array("username"=>$form->get("username")->getData()));
            if(count($user)==0){
                // Encriptamos la contrasena
                $factory = $this->get("security.encoder_factory");
                $encoder = $factory->getEncoder($usuario);
                $contrsena = $encoder->encodePassword($form->get("contrasena")->getData(), $usuario->getSalt());
                $usuario->setContrasena($contrsena);
                //guardamos el usuario creado
                $em=$this->getDoctrine()->getManager();
                $em->persist($usuario);
                $flush= $em->flush();
                if($flush==null){
                   $status="Se creo correctamente";
                }{
                    $status="No se creo ";
                }

            }else
            {
                $status="no se guardo usuario existe";

            }


            $helpers=$this->get(Helpers::class);
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
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            // $helpers =$this->get("app.helpers");
            //mismo metodo que el anterior pero usando el servicios de simfony
            $jsonContent=$this->get('serializer')->serialize($usuario,'json');

            $jsonContent=json_decode($jsonContent,true);
            return new JsonResponse($jsonContent);
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