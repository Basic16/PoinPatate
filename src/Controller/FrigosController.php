<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Frigos;
use App\Entity\Variete;
use App\Form\AjoutFrigosType;
use App\Form\ModifFrigoType;


class FrigosController extends AbstractController
{
    /**
     * @Route("/tableFrigo/{id}", name="tableFrigo", requirements={"id"="\d+"})
     */
    public function tableFrigo(int $id, Request $request): Response
    {
        
        $em = $this->getDoctrine();
        $repoVariete = $em->getRepository(Variete::class);
        $repoFrigo = $em->getRepository(Frigos::class);
        $frigo = $repoFrigo->findOneby(array('id'=>$id));
        $varietes = $repoVariete->findBy(array(), array('nom' => 'ASC'));
        if ($request->isXmlHttpRequest())
      {
         $nom = $frigo->getNom();
         $data    = $_POST["result"];
         $data    = json_decode("$data", true);
         $chaineFinale = "";
         for ($i = 0; $i <= count($data)-1; $i++) {
            for ($a = 0; $a <  count($data[0]); $a++) {
                if($a != count($data[0])-1){
                $chaineFinale = $chaineFinale . $data[$i][$a] . ";";}
                else{
                    $chaineFinale = $chaineFinale . $data[$i][$a] . "";
                }
               
        }
         $chaineFinale = $chaineFinale . "\n";
         
         
      }
      
      file_put_contents('../public/csv/'.$nom.'.csv', $chaineFinale);
      
    } 
        return $this->render('frigos/tableFrigo.html.twig', [
            'controller_name' => 'FrigosController',
            'varietes' => $varietes,
            'frigo' => $frigo
        ]);
    }

    /**
     * @Route("/liste_frigos", name="liste_frigos")
     */
    public function listeFrigos(Request $request): Response
    {
        $frigo = new Frigos();
        $em = $this->getDoctrine();


        $repoFrigo = $em->getRepository(Frigos::class);

        if ($request->get('supp') != null) {
            $frigo = $repoFrigo->find($request->get('supp'));
            if ($frigo != null) {
                $em->getManager()->remove($frigo);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_frigos');
        }

        $frigos = $repoFrigo->findBy(array());
        return $this->render('frigos/liste_frigos.html.twig', [
            'frigos' => $frigos,


        ]);
    }
    /**
     * @Route("/modif_frigo/{id}", name="modif_frigo", requirements={"id"="\d+"})
     */
    public function modifFrigo(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoFrigo = $em->getRepository(Frigos::class);
        $frigo = $repoFrigo->find($id);
        if ($frigo == null) {
            $this->addFlash('notice', "Ce frigo n'existe pas");
            return $this->redirectToRoute('liste_frigos');
        }
        $form = $this->createForm(ModifFrigoType::class, $frigo);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('CSV')->getData();
                $nom = $form->get('nom')->getData();
                $fileName = $nom . '.' . 'csv';


                $em = $this->getDoctrine()->getManager();
                try {
                    $file->move($this->getParameter('csv_directory'), $fileName);
                    $em = $this->getDoctrine()->getManager();
                    $frigo->setCSV($fileName);
                    $em->persist($frigo);
                    $em->flush();
                } catch (FileException $e) {
                    $this->addFlash('notice', 'Problème fichier inséré');
                }

                $this->addFlash('notice', 'Frigo ajouté');
            }

            return $this->redirectToRoute('liste_frigos');
        }
        return $this->render('frigos/modif_frigo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ajout_frigo", name="ajout_frigo")
     */
    public function ajoutFrigo(Request $request)
    {
        $frigo = new Frigos();
        $form = $this->createForm(AjoutFrigosType::class, $frigo);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $nom = $form->get('nom')->getData();
                $largeur = $form->get('Largeur')->getData();
                $longueur = $form->get('Longueur')->getData();
                $frigo->setCSV($nom.'.csv');
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($frigo);
                $em->flush();
              
                $chaineFinale = "";
                for($j = 1; $j <= $largeur; $j++){
                    if($j != $largeur){
                    $chaineFinale =  $chaineFinale . "C" . $j . " variete" . ";";
                    $chaineFinale =  $chaineFinale . "C" . $j . " producteur" . ";";
                    $chaineFinale =  $chaineFinale . "C" . $j . " calibre" . ";";
                    $chaineFinale =  $chaineFinale . "C" . $j . " qte" . ";";}
                    else{
                        $chaineFinale =  $chaineFinale . "C" . $j . " variete". ";" ;
                        $chaineFinale =  $chaineFinale . "C" . $j . " producteur". ";" ;
                        $chaineFinale =  $chaineFinale . "C" . $j . " calibre". ";";
                        $chaineFinale =  $chaineFinale . "C" . $j . " qte" ;}
                    }
               
                $chaineFinale = $chaineFinale . "\n";

                for ($i = 0; $i <= ($longueur)-1; $i++) {
                   for ($a = 0; $a <  ($largeur*4); $a++) {
                       if($a != ($largeur*4)-1){
                       $chaineFinale = $chaineFinale . "vide" . ";";}
                       else{
                           $chaineFinale = $chaineFinale . "vide" . "";
                       }
                      
               }
                $chaineFinale = $chaineFinale . "\n";
                
                
             }
             file_put_contents('../public/csv/'. $nom .'.csv', $chaineFinale);
             
                $this->addFlash('notice', 'Frigo ajouté');
                return $this->redirectToRoute('liste_frigos');
            } }

        
        
        return $this->render('frigos/ajout_frigo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
}
