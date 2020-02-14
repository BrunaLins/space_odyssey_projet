<?php

namespace App\Controller;

use App\Repository\DestinationRepository;
use App\Repository\TypeHebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypehebergementController
 * @package App\Controller
 * @Route("/hebergement")
 */
class TypehebergementController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(TypeHebergementRepository $repository)
    {

        $hebergements = $repository->findAll();
        dump($hebergements);

        return $this->render('typehebergement/index.html.twig',
         [
            'hebergements' => $hebergements,
        ]
        );
    }

}
