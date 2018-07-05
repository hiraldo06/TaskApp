<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 10/7/18
 * Time: 12:52 PM
 */

namespace AppBundle\Controller\Tasks;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskRestController extends Controller{

    /**
     * @Route("rest/task", name="task_list")
     * @Method("GET")
     * @return Response
     */
    public function listAction(){

        $tickets=$this->getDoctrine()->
        getRepository(Ticket::class)
            ->findAll();

        $helpers=$this->get("app.helpers");
        return $helpers->json2($tickets);
    }

}