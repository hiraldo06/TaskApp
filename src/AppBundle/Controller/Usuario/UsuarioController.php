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
use Symfony\Component\HttpFoundation\Response;


class UsuarioController extends Controller
{



    /**
     * @Route("/usuario",options={"expose"=true}, name="users", requirements={"page"="\d+"})
     */
    public function indexUsuario(){

        $usuarios=$this->getDoctrine()->
        getRepository(Usuario::class)
        ->findAll();

        return $this->render('@App/Usuario/lista.html.twig', [
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/usuario/add", name="add_usuario")
     */
    public function crearUsuario(){
        $usuario=new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        return $this->render('@App/Usuario/crear_usuario.html.twig', [
            'form' => $form->createView()

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
        $form = $this->createForm(UsuarioType::class, $usuario);

        return $this->render('@App/Usuario/editar_usuario.html.twig', [
            'form' => $form->createView(),
            'usuario'=>$usuario
        ]);
    }




}