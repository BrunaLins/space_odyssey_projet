<?php

namespace App\Controller;


use App\Repository\SejourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
class SearchController extends AbstractController
{


    /**
     * @Route("/search")
     */
    public function index(SessionInterface $session, SejourRepository $repository)
    {
        if ($session->has('search-data')) {
            $result = $repository->findAllTri($session->get('search-data'));
            dump($result);
        }

        return $this->render('search/index.html.twig',
            ['result'=>$result]);
    }
}