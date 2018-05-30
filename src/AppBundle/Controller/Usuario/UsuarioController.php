<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 11/6/18
 * Time: 6:33 PM
 */

namespace AppBundle\Controller\Usuario;


use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}