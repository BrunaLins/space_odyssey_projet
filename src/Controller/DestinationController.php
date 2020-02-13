<?php

namespace App\Controller;

use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{
    /**
     * @Route("/destination", name="destination")
     */
    public function index()
    {
        return $this->render('destination/index.html.twig', [
            'controller_name' => 'DestinationController',
        ]);
    }


    public function menu(DestinationRepository $repository) // pas de route car c'est un bout de page qu'on va intégrer dans les pages
    {
        $destinations = $repository->findBy([], ['id' => 'ASC']);

        return $this->render(
            'destination/menu.html.twig',
            ['destinations' => $destinations]
        );
    }
}
