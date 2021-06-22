<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class DefaultController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

   /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return $this->render('frigos/test.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}