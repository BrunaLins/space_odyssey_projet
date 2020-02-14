<?php

namespace App\Controller;

use App\Repository\DestinationRepository;
use App\Repository\TypeHebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypehebergementController
 * @package App\Controller
 * @Route("/typehebergement")
 */
class TypehebergementController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(TypeHebergementRepository $repository)
    {

        $typehebergements = $repository->findAll();

        return $this->render('typehebergement/index.html.twig',
         [
            'typehebergements' => $typehebergements
        ]
        );
    }

}
