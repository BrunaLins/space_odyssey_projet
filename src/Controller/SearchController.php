<?php

namespace App\Controller;


use App\Entity\Destination;
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


    /**
     * @Route("/{id}",requirements={"id": "\d+"})
     */
    public function index2(SejourRepository $repository, Destination $destination)
    {
        $result=$repository->findby(['destination' => $destination],['id'=>'ASC']);

        return $this->render('search/index.html.twig', ['result' =>$result]);
    }
}