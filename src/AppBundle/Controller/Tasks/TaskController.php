<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 19/6/18
 * Time: 3:39 PM
 */

namespace AppBundle\Controller\Tasks;


use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller {


    /**
     * @Route("/task/ver/{id}", name="ver_task")
     */
    public function verTask($id){


        return $this->render('@App/Tasks/ticket.html.twig', [
            'id' => $id
        ]);

    }

    /**
     * @Route("/task", name="tasks")
     */
    public function indexTask(){


        return $this->render('@App/Tasks/lista.html.twig', [
            'tasks' => "Tareas"
        ]);

    }

    /**
     * @Route("/pendiente", name="pendiente_tasks")
     */
    public function pendienteTask(){


        return $this->render('@App/Tasks/pendiente.html.twig', [
            'tasks' => "Tareas"
        ]);

    }


    /**
     * @Route("/proceso", name="en_proceso_tasks")
     */
    public function enProcesoTask(){


        return $this->render('@App/Tasks/proceso.html.twig', [
            'tasks' => "Tareas"
        ]);

    }


    /**
     * @Route("/task/crear", name="crear_task")
     */
    public function crearTask(){

        $usuarios=$this->getDoctrine()->getRepository(Usuario::class)
            ->findByRolesUsuario('ROLE_TECNICO');

        return $this->render('@App/Tasks/add_ticket.html.twig', [
            'usuariosAsignado' => $usuarios
        ]);

    }

}