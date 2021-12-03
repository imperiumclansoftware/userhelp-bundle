<?php
namespace ICS\UserhelpBundle\Controller;

use ICS\UserhelpBundle\Entity\IntroSaver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserhelpController extends AbstractController
{

    /**
    * @Route("/recordforuser",name="ics-userhelp-record-intro-finished")
    */
    public function index(Request $request)
    {
        $route = $request->get('route');
        $userId = $this->getUser()->getId();

        $rec=$this->getDoctrine()->getRepository(IntroSaver::class)->findBy([
            'introRoute' => $route,
            'userId' => $userId
        ]);

        if(count($rec) == 0)
        {
            $record = new IntroSaver();
            $record
                ->setIntroRoute($route)
                ->setUserId($userId);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($record);
            $em->flush();    
        }

        return new Response('ok');
    }

}