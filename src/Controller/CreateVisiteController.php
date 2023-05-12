<?php

namespace App\Controller;

use App\Entity\Exposition;
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
        $nbAdultes = $request ->get('nbAdultes');
        $nbEnfants = $request ->get('nbEnfants');
        $i = 1;

        for ($i = 1; $i =count($lesExpos); $i++){
            $request->get($i);
        }

        return $this->render('create_visite/index.html.twig', [
            'lesExpos' => $lesExpos,
        ]);

    }
}
