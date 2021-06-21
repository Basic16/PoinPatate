<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Variete;

class VarieteController extends AbstractController
{
    /**
    * @Route("/liste_varietes", name="liste_varietes")
    */
   public function listeVarietes(Request $request): Response
   {
       $variete = new Variete(); 
       $em = $this->getDoctrine();
       
       $repoVariete = $em->getRepository(Variete::class);
       if ($request->get('supp') != null) {
           $variete = $repoVariete->find($request->get('supp'));
           if ($variete != null) {
               $em->getManager()->remove($variete);
               $em->getManager()->flush();
           }
           return $this->redirectToRoute('liste_varietes');
       }

       $varietes = $repoVariete->findBy(array());
       return $this->render('variete/liste_variete.html.twig', [
           'varietes' => $varietes,
           
       ]);
   }
}
