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
use AppBundle\Form\TicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskRestController extends Controller{




    /**
     * @Route("rest/task/{id}", options={"expose"=true}, name="task_list")
     * @Method("GET")
     * @param Usuario $usuario
     * @return Response
     */
    public function listAction(Usuario $usuario){

        $tickets=$this->getDoctrine()->
        getRepository(Ticket::class)
            ->findOneByIdJoinedToUsuario($usuario);

        $helpers=$this->get("app.helpers");
        return $helpers->json2($tickets);
    }
    /**
     * @Route("rest/task/ver/{id}", options={"expose"=true}, name="rest_ver_task")
     * @Method("GET")
     * @param Ticket $ticket
     * @return Response
     */
    public function verAction(Ticket $ticket){
        $tickets=$this->getDoctrine()->
        getRepository(Ticket::class)
            ->find($ticket);

        $helpers=$this->get("app.helpers");
        return $helpers->json2($tickets);
    }
    /**
     * @Route("rest/task/pendiente/{id}", options={"expose"=true}, name="rest_pendiente_task")
     * @Method("GET")
     * @param Usuario $usuario
     * @return Response
     */
    public function pedienteAction(Usuario $usuario){

        $tickets=$this->getDoctrine()->
        getRepository(Ticket::class)
            ->findBy([
                "usuario"=>$usuario,
                "estado"=> "PENDIENTE"
            ]);

        $helpers=$this->get("app.helpers");
        return $helpers->json2($tickets);
    }

    /**
     * @Route("rest/task/proceso/{id}", options={"expose"=true}, name="rest_en_proceso_task")
     * @Method("GET")
     * @param Usuario $usuario
     * @return Response
     */
    public function procesoAction(Usuario $usuario){

        $tickets=$this->getDoctrine()->
        getRepository(Ticket::class)
            ->findBy([
                "usuario"=>$usuario,
                "estado"=> "EN_PROCESO"
            ]);

        $helpers=$this->get("app.helpers");
        return $helpers->json2($tickets);
    }

    /**
     * @Route("/rest/task/update/{id}", options={"expose"=true},name="rest_update_ticket")
     * @Method("PUT")
     * @param Request $request
     * @param Ticket $ticket
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,Ticket $ticket){

        $data=$request->getContent();

        $data=(json_decode($data,true));

        if($data["estado"]=="PENDIENTE"){
            $estado="EN_PROCESO";
        }elseif ($data["estado"]=="EN_PROCESO"){
            $estado="LISTO";
        }
        $ticket->setEstado($estado);
            $em=$this->getDoctrine()->getManager();
            $em->flush();

        $helpers=$this->get("app.helpers");
        return $helpers->json2($ticket);
    }

    /**
     * @Route("/rest/task/add", options={"expose"=true}, name="rest_crear_task")
     * @Method("POST")
     * @return Response
     */
    public function addAction(Request $request){



        $data=$request->getContent();
        $data=(json_decode($data,true));
        $ticket=new Ticket();
        $form=$this->createForm(TicketType::class,$ticket);
        $form->submit($data);
       // $ticket->setDescripcion("hola mundo");
        $ticket->setEstado("PENDIENTE");
        $ticket->setFechaCreado(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();

        $helpers =$this->get("app.helpers");
        return $helpers->json2($ticket);
    }



}