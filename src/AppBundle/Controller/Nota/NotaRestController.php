<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 14/7/18
 * Time: 8:32 AM
 */

namespace AppBundle\Controller\Nota;


use AppBundle\Entity\Nota;
use AppBundle\Entity\Ticket;
use AppBundle\Form\NotaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotaRestController extends Controller
{
    /**
     * @Route("rest/nota/{id}", options={"expose"=true},name="rest_notas")
     * @Method("GET")
     * @param Ticket $ticket
     * @return Response
     */
    public function notasAction(Ticket $ticket){
        $notas=$this->getDoctrine()
            ->getRepository(Nota::class)
            ->findBy(["ticket"=>$ticket]);
        $helpers=$this->get("app.helpers");
        return $helpers->json2($notas);
    }

    /**
     * @Route("rest/nota/add", options={"expose"=true},name="rest_add_nota")
     * @Method("POST")
     * @return Response
     */
    public function addAction(Request $request){
        $data=$request->getContent();
        $data=json_decode($data,true);
        $nota=new Nota();
        $nota->setFecha(new \DateTime());
        $form=$this->createForm(NotaType::class,$nota);
        $form->submit($data);


        $em=$this->getDoctrine()->getManager();
        $em->persist($nota);
        $em->flush();


        $helpers=$this->get("app.helpers");
        return $helpers->json2($nota);
    }
}