<?php

namespace App\Controller;

use App\Repository\CalibreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Calibre;

class CalibreController extends AbstractController
{
    /**
     * @Route("/calibre", name="calibre")
     */
    public function theme(CalibreRepository $calibreRepository, Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoCalibre = $em->getRepository(Calibre::class);
        
        $calibres = $repoCalibre->findBy(array(), array('calibre' => 'ASC'));
        return $this->render('calibre/calibres.html.twig', [
            'calibres' => $calibres
           
        ]);
    }
}
