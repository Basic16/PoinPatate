<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalibreController extends AbstractController
{
    /**
     * @Route("/calibre", name="calibre")
     */
    public function index(): Response
    {
        return $this->render('calibre/index.html.twig', [
            'controller_name' => 'CalibreController',
        ]);
    }
}
