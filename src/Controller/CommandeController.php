<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Entity\Sejour;
use App\Entity\User;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommandeController
 * @package App\Controller
 *
 * @Route("/info")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(CommandeRepository $repository)
    {
        $user = $this->getUser();
        $commandes = $repository->findBy(
            ['user' => $user],
            ['id' => 'ASC']
        );
        // dump($commandes);


        return $this->render('user/index.html.twig',
            ['commandes' => $commandes]);
    }
}
