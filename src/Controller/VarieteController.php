<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Variete;
use App\Form\AjoutVarieteType;
use App\Form\ModifVarieteType;

class VarieteController extends AbstractController
{
    /**
    * @Route("/liste_varietes", name="liste_varietes")
    */
   public function listeVarietes(Request $request): Response
   {
       $variete = new Variete(); 
       $em = $this->getDoctrine();
       
       $form = $this->createForm(AjoutVarieteType::class, $variete);
       $repoVariete = $em->getRepository(Variete::class);

       if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $em->persist($variete); // Nous enregistrons notre nouveau thème
            $em->flush(); // Nous validons notre ajout
            $this->addFlash('notice', 'Variété insérée'); // Nous préparons le message à

        }
        return $this->redirectToRoute('liste_varietes');
    }
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
           'form' => $form->createView() 
           
       ]);
   }

   /**
     * @Route("/modif_variete/{id}", name="modif_variete", requirements={"id"="\d+"})
     */
    public function modifVariete(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoVariete = $em->getRepository(Variete::class);
        $variete = $repoVariete->find($id);
        if ($variete == null) {
            $this->addFlash('notice', "Cette variété n'existe pas");
            return $this->redirectToRoute('liste_variete');
        }
        $form = $this->createForm(ModifVarieteType::class, $variete);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($variete);
                $em->flush();
                $this->addFlash('notice', 'Variété modifiée');
            }
            return $this->redirectToRoute('liste_varietes');
        }
        return $this->render('variete/modif_variete.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
