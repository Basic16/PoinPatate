<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Producteurs;
use App\Form\AjoutProducteurType;
use App\Form\ModifProducteurType;

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

   /**
     * @Route("/ajout_producteur", name="ajout_producteur")
     */
    public function ajoutProducteur(Request $request)
    {
        $producteur = new Producteurs(); 
        $form = $this->createForm(AjoutProducteurType::class, $producteur);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {


                $em = $this->getDoctrine()->getManager();

                $em->persist($producteur); 
                $em->flush(); 
                $this->addFlash('notice', 'Producteur ajouté'); 

            }
            return $this->redirectToRoute('ajout_producteur');
        }
        return $this->render('producteur/ajoutProducteur.html.twig', [
            'form' => $form->createView() 
        ]);
    }

    /**
     * @Route("/modif_producteur/{id}", name="modif_producteur", requirements={"id"="\d+"})
     */
    public function modifProducteur(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoProducteur = $em->getRepository(Producteurs::class);
        $producteur = $repoProducteur->find($id);
        if ($producteur == null) {
            $this->addFlash('notice', "Ce Producteur n'existe pas");
            return $this->redirectToRoute('liste_producteurs');
        }
        $form = $this->createForm(ModifProducteurType::class, $producteur);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($producteur);
                $em->flush();
                $this->addFlash('notice', 'Producteur modifié');
            }
            return $this->redirectToRoute('liste_producteurs');
        }
        return $this->render('producteur/modifProducteur.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
