<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    /**
     * @Route("/ville/{codePostal}", name="get_ville")
     */
    public function getVilles(Request $request,VilleRepository $villeRepository,$codePostal)
    {
        $villes = $villeRepository->getCitiesDept($codePostal);
        // composer require symfony/serializer-pack
        $villes = $this->get('serializer')->serialize($villes, 'json');
        return $this->json($villes);
    }

}
