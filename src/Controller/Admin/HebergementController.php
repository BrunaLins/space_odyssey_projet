<?php


namespace App\Controller\Admin;


use App\Entity\Hebergement;
use App\Form\HebergementType;
use App\Repository\HebergementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HebergementController
 * @package App\Controller\Admin
 *
 * @Route("/hebergement")
 */
class HebergementController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(HebergementRepository $repository)
    {
        $hebergements = $repository->findBy(
            [], ['id'=>'ASC']);
        dump($hebergements);

        return $this->render(
            'admin/hebergement/index.html.twig',
            ['hebergements' => $hebergements]
        );
    }

    /**
     * @Route("/edition/{id}", defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        if(is_null($id)){
            $hebergement = new Hebergement();
        } else {
            $hebergement = $manager->find(Hebergement::class, $id);

            if(is_null($hebergement)) {
               throw new NotFoundHttpException();
           }
        }

        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {

                $manager->persist($hebergement);
                $manager->flush();
                $this->addFlash('success', 'L\'hébergement est enregistré');
                return $this->redirectToRoute('app_admin_hebergement_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'admin/hebergement/edit.html.twig',
            ['form' => $form->createView()]
        );

    }

    /**
     * @Route("/suppression/{id}", requirements={"id": "\d+"})
     */
    public function delete(EntityManagerInterface $manager, Hebergement $hebergement)
    {
        $manager->remove($hebergement);
        $manager->flush();

        $this->addFlash('success', 'L\'hébergement est supprimé');

        return $this->redirectToRoute('app_admin_hebergement_index');
    }


}