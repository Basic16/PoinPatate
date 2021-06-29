<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use App\Entity\Variete;
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
    public function test( Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoCalibre = $em->getRepository(Variete::class);
        $varietes = $repoCalibre->findBy(array(), array('nom' => 'ASC'));
        if ($request->isXmlHttpRequest())
      {
          
         $data    = $_POST["result"];
         $data    = json_decode("$data", true);
         $chaineFinale = "";
         for ($i = 0; $i <= count($data)-1; $i++) {
            for ($a = 0; $a <  count($data[0]); $a++) {
                $chaineFinale = $chaineFinale . $data[$i][$a] . ";";
               
        }
         $chaineFinale = $chaineFinale . "\n";
         
         
      }
      file_put_contents('../public/csv/demo.csv', $chaineFinale);
    
    } 
        return $this->render('frigos/test.html.twig', [
            'controller_name' => 'DefaultController',
            'varietes' => $varietes
        ]);
    
}
}