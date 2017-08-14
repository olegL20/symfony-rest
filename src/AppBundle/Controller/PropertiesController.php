<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Properties;



class PropertiesController extends Controller
{public function signRequest($method, $uri, $body, $timestamp, $secretKey)
{
    $string = implode("\n", [
        $method,
        $uri,
        $body,
        $timestamp,
    ]);

    return hash_hmac('sha256', $string, $secretKey);
}
    /**
     * @Route("/property/show")
     * @Method("GET")
     *
     */


    public function ShowAction(Request $request)
    {
        $pr = $this->getDoctrine()->getRepository("AppBundle:Properties")->findAll();

        $uri = $request->getUri();
        $timestamp = time();
        $secret_key = "ee8be9ba7377d9f57258de04efa765b4e30da161";
        $method =$request->getMethod();
        $options = array(null);
        $body =json_encode($options);
        $signature = $this->signRequest($method, $uri, $body, $timestamp, $secret_key);
        $response = new Response();
        $response->headers->set('Accept',"application/json");
        $response->headers->set('X-USER-ID',"1");
        $response->headers->set('timestamp',$timestamp);
        $response->headers->set(' X-AUTH-TOKEN',$signature);

       $response->setContent($this->render('AppBundle:Properties:show.html.twig',array("properties"=>$pr,)));
        return $response;
    }

    /**
     * @Route("/property/add")
     * @Method("PUT")
     */
    public function AddAction(Request $request)
    {

        $property = new Properties();
        $property->setPropertyName($request->get('name'));
        $property->setPropertyValue($request->get('value'));


        $manager = $this->getDoctrine()->getManager();
        $manager->persist($property);
        $manager->flush();

        $uri = $request->getUri();
        $timestamp = time();
        $secret_key = "ee8be9ba7377d9f57258de04efa765b4e30da161";
        $method =$request->getMethod();
        $options = array('property_name'=>$request->get('name'), 'property_value'=>$request->get('value'));
        $body =json_encode($options);
        $signature = $this->signRequest($method, $uri, $body, $timestamp, $secret_key);
        $response = new Response('Created new Object of entity "Properties"');
        $response->headers->set('Accept',"application/json");
        $response->headers->set('X-USER-ID',"1");
        $response->headers->set('timestamp',$timestamp);
        $response->headers->set(' X-AUTH-TOKEN',$signature);


        return $response;
    }

    /**
     * @Route("property/{id}/edit")
     * @Method("PATCH")
     */
    public function EditAction(Request $request,$id)
    {

        $property = $this->getDoctrine()->getRepository('AppBundle:Properties')->find($id);

        $property->setPropertyName($request->get('name'));
        $property->setPropertyValue($request->get('value'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($property);
        $manager->flush();
        $uri = $request->getUri();
        $timestamp = time();
        $secret_key = "ee8be9ba7377d9f57258de04efa765b4e30da161";
        $method =$request->getMethod();
        $options = array('id'=>$id,'property_name'=>$request->get('name'), 'property_value'=>$request->get('value'));
        $body =json_encode($options);
        $signature = $this->signRequest($method, $uri, $body, $timestamp, $secret_key);
        $response = new Response('Edited Object of entity "Properties"');
        $response->headers->set('Accept',"application/json");
        $response->headers->set('X-USER-ID',"1");
        $response->headers->set('timestamp',$timestamp);
        $response->headers->set(' X-AUTH-TOKEN',$signature);


        return $response;
    }

   /**
     * @Route("property/{id}/delete")
     * @Method("DELETE")
     */
    public function DeleteAction(Request $request,$id)
    {
        $property = $this->getDoctrine()->getRepository('AppBundle:Properties')->find($id);


        $manager = $this->getDoctrine()->getManager();
        $manager->remove($property);
        $manager->flush();

        $uri = $request->getUri();
        $timestamp = time();
        $secret_key = "ee8be9ba7377d9f57258de04efa765b4e30da161";
        $method =$request->getMethod();
        $options = array('id'=>$id);
        $body =json_encode($options);
        $signature = $this->signRequest($method, $uri, $body, $timestamp, $secret_key);
        $response = new Response('Deleted Object of entity "Properties"');
        $response->headers->set('Accept',"application/json");
        $response->headers->set('X-USER-ID',"1");
        $response->headers->set('timestamp',$timestamp);
        $response->headers->set(' X-AUTH-TOKEN',$signature);
        return $response;
    }

}
