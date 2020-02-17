<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\DestinationRepository;
use App\Repository\SejourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DestinationController
 * @package App\Controller
 * @Route("/destination")
 */
class DestinationController extends AbstractController
{
    /**
     * @Route("/{id}",requirements={"id": "\d+"})
     */
    public function index(SejourRepository $repository,Destination $destination)
    {
        $sejours=$repository->findby([],['id'=>'ASC']);

        return $this->render('destination/index.html.twig', ['sejours' =>$sejours]);
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
