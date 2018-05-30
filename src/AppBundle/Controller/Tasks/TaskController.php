<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 19/6/18
 * Time: 3:39 PM
 */

namespace AppBundle\Controller\Tasks;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller {

    /**
     * @Route("/task", name="tasks")
     */
    public function indexTask(){


        return $this->render('@App/Tasks/lista.html.twig', [
            'tasks' => "Tareas"
        ]);

    }

}