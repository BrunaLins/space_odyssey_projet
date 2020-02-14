<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\CommandeRepository;
use App\Repository\DestinationRepository;
use App\Repository\SejourRepository;
use App\Repository\TypeHebergementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(
        DestinationRepository $repository,
        SejourRepository $repository2,
        TypeHebergementRepository $repository3,
        UserRepository $repository4,
        CommandeRepository $repository5,
        Request $request)

    {
        $destinations = $repository->findBy(
            [],
            ['id' => 'ASC']
        );

        $sejours = $repository2->findBy(
            [],
            ['id' => 'ASC']
        );

        $typehebergements = $repository3->findBy(
            [],
            ['id' => 'ASC']
        );

        $users = $repository4->findBy(
            [],
            ['id' => 'ASC']
        );

        $commandes = $repository5->findBy(
            [],
            ['id' => 'ASC']
        );

        // Formulaire de recherche

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $result = $repository2->findAllTri($form->getData());

            dump($result);
        }

        //Fin Formulaire de recherche

        return $this->render(
            'index/index.html.twig',
            [
                'sejours' => $sejours,
                'destinations' => $destinations,
                'typehebergements' => $typehebergements,
                'users' => $users,
                'commandes' => $commandes,
                'form'=>$form->createView(),
            ]);
    }


}
