<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 20/6/18
 * Time: 1:38 PM
 */

namespace AppBundle\Services;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Helpers
{
    public function json($data){
        $encoders=array(new JsonEncoder());
        $normalizers=array(new ObjectNormalizer());
        $serializer=new Serializer($normalizers,$encoders);
        $jsonContent=json_decode($serializer->serialize($data,'json'),true);
        return $jsonContent;
    }
}