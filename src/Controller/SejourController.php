<?php

namespace App\Controller;

use App\Entity\Sejour;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\SejourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SejourController
 * @package App\Controller
 *
 * @Route("/sejour")
 */

class SejourController extends AbstractController


{
    /**
     * @Route("/{id}", requirements={"id","\d+"})
     *
     */
public function index(Request $request, EntityManagerInterface $manager,
                      Sejour $sejour, CommentRepository $repository)

{

    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

        if ($form->isValid()) {
            $comment->setUser($this->getUser())
                ->setSejour($sejour);

            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('success', 'vote commentaire est enregistré');
            return $this->redirectToRoute('app_sejour_index', ['id' => $sejour->getId()]);

        } else {
            $this->addFlash('error', 'La formulaire contient de erreurs');
        }
    }

    return $this->render('sejour/index.html.twig', ['sejour' => $sejour,
            'form' => $form->createView(),
        ]

    );
}

    /**
     * @param SejourRepository $repository
     *
     * @Route("/best")
     */
    public function best( SejourRepository $repository)

    {
        $sejours = $repository->getBest();
        dump($sejours);


        return $this->render('index/best.html.twig', ['sejours' => $sejours]);

    }


}
