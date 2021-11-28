<?php
namespace ICS\UserhelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserhelpController extends AbstractController
{

    /**
    * @Route("/",name="ics-userhelp-homepage")
    */
    public function index()
    {

        return $this->render('@Userhelp\index.html.twig',[]);
    }

}