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
        $lesExpos = $doctrine->getRepository(Exposition::class)-> findAll();
        $uneVisite = new Visite();
        $uneVisite->setDateHeureArrivee(new \DateTime('now'));
        $uneVisite->setDateHeureDepart(new \DateTime('now'));
        $uneVisite->setNbVisiteursAdultes(0);
        $uneVisite->setNbVisiteursEnfants(0);
        $nbAdultes = $request ->get('nbAdultes');
        $nbEnfants = $request ->get('nbEnfants');
        $i = 1;

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

        return $this->render('create_visite/index.html.twig', [
            'lesExpos' => $lesExpos,
        ]);

    }
}
