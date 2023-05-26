<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class CreateVisiteController extends AbstractController
{
    #[Route('/', name: 'app_create_visite')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $jauge = 10;
        $erreurA = "";
        $erreurE = "";
        $lesExpos = $doctrine->getRepository(Exposition::class)-> findAll();
        $uneVisite = new Visite();
        $uneVisite->setDateHeureArrivee(new \DateTime('now'));
        $uneVisite->setDateHeureDepart(new \DateTime('now'));
        $uneVisite->setNbVisiteursAdultes(0);
        $uneVisite->setNbVisiteursEnfants(0);
        $ajout = null;


        if($request ->get('nbAdultes') !== null){
            $uneVisite->setNbVisiteursAdultes($request ->get('nbAdultes'));
        }
        if($request ->get('nbEnfants') !== null){
            $uneVisite->setNbVisiteursEnfants($request ->get('nbEnfants'));
        }


        foreach ($lesExpos as $expo)
        {
            if ($request->get($expo->getId()))
            {
                $uneVisite->addExposition($expo);
            }
        }
        /*for ($i = 1; $i =count($lesExpos); $i++){
            $request->get($i);
        }*/



        if($request->get('nbAdultes') > $jauge){
            $erreurA = "le nombre maximum d'adulte est dépassé";
        }
        if($request->get('nbEnfants') > $jauge){
            $erreurE = "le nombre maximum d'enfant est dépassé";
        }
        if($request->get('valider')!==$ajout){
            $doctrine->getManager()->persist($uneVisite);
            $doctrine->getManager()->flush();
        }

        return $this->render('create_visite/index.html.twig', [
            'lesExpos' => $lesExpos,
            'visite' => $uneVisite,
            'erreurA' => $erreurA,
            'erreurE' => $erreurE,
        ]);



    }
}
