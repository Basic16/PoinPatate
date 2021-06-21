<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Producteurs;

class ProducteurController extends AbstractController
{
    /**
    * @Route("/liste_producteurs", name="liste_producteurs")
    */
   public function listeEpreuve(Request $request): Response
   {
       $producteur = new Producteurs(); 
       $em = $this->getDoctrine();
       
       $repoProducteur = $em->getRepository(Producteurs::class);
       if ($request->get('supp') != null) {
           $producteur = $repoProducteur->find($request->get('supp'));
           if ($producteur != null) {
               $em->getManager()->remove($producteur);
               $em->getManager()->flush();
           }
           return $this->redirectToRoute('liste_producteurs');
       }

       $producteurs = $repoProducteur->findBy(array());
       return $this->render('producteur/liste_producteur.html.twig', [
           'producteurs' => $producteurs,
           
       ]);
   }

}
