<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Frigos;
use App\Form\AjoutFrigosType;
use App\Form\ModifFrigoType;


class FrigosController extends AbstractController
{
    /**
     * @Route("/tableFrigo", name="tableFrigo")
     */
    public function index(): Response
    {
        return $this->render('frigos/csvMaker.html.twig', [
            'controller_name' => 'FrigosController',
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
                $file = $form->get('CSV')->getData();
                $nom = $form->get('nom')->getData();
                $fileName = $nom . '.' . $file->guessExtension();

                $em = $this->getDoctrine()->getManager();
                try {
                    $file->move($this->getParameter('csv_directory'), $fileName);
                    $em = $this->getDoctrine()->getManager();
                    $frigo->setCSV($fileName);
                    $em->persist($frigo);
                    $em->flush();
                } catch (FileException $e) {
                    $this->addFlash('notice', 'Problème de CSV inséré');
                }

                $this->addFlash('notice', 'Frigo ajouté');
            }

            return $this->redirectToRoute('liste_frigos');
        }
        return $this->render('frigos/ajout_frigo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
