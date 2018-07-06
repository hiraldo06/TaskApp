<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {       //llamamos el servicios

        if ($this->getUser()!=null){
            return $this->redirectToRoute("home");
        }
        $authenticationUtils=$this->get("security.authentication_utils");
        $error=$authenticationUtils->getLastAuthenticationError();
        $lastUsername=$authenticationUtils->getLastUserName();


        // replace this example code with whatever you need
        return $this->render('@App/Login/index.html.twig', [
            "error"=>$error,
            "last_username"=>$lastUsername
        ]);
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
       // return $this->redirectToRoute('login');
    }

    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'homepage' => "Home TaskApp",
        ]);
    }

    /**
     * @Route("/registro", name="registro")
     */
    public function crearUsuario(){
        $usuario=new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        return $this->render('@App/Login/registro_usuario.html.twig', [
            'form' => $form->createView()

        ]);
    }
}
