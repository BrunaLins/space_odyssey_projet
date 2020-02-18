<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Repository\CommandeRepository;
use App\Repository\CommentRepository;
use App\Repository\DestinationRepository;
use App\Repository\SejourRepository;
use App\Repository\TypeHebergementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        CommentRepository $repository6,
        Request $request,
        SessionInterface $session
)

    {
        $destinations = $repository->findBy(
            [],
            ['id' => 'ASC']
        );

        $sejours = $repository2->findBy(
            [],
            ['id' => 'ASC'],
            5
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

        $comments = $repository6->findBy(
            [],
            ['note' => 'DESC'],
            5
        );

        // Formulaire de recherche

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $session->set('search-data', $form->getData());
            return $this->redirectToRoute('app_search_index');
            //dump($result);
        }

        $bestSejours = $repository2->getBest();

        //Fin Formulaire de recherche

        return $this->render(
            'index/index.html.twig',
            [
                'sejours' => $sejours,
                'destinations' => $destinations,
                'typehebergements' => $typehebergements,
                'users' => $users,
                'commandes' => $commandes,
                'comments' => $comments,
                'form'=>$form->createView(),
                'best_sejours' => $bestSejours
            ]);
    }


}
