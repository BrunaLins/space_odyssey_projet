<?php


namespace App\Controller\Admin;


use App\Entity\Sejour;
use App\Form\SejourType;
use App\Repository\SejourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SejourController
 * @package App\Controller\Admin
 *
 * @Route("/sejour")
 */
class SejourController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(SejourRepository $repository)
    {
        $sejours = $repository->findBy([], ['id'=>'ASC']);
        // dump($sejours);
        return $this->render(
            'admin/sejour/index.html.twig',
            ['sejours' => $sejours]
        );
    }

    /**
     * @Route("/edition/{id}"), defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        if(is_null($id)) {
            $sejour = new Sejour();
        } else { // on recupère le séjour et on le modifie
            $sejour = $manager->find(Sejour::class, $id);

            /*if(is_null($sejour)) {
                throw new NotFoundHttpException();
            }*/
        }

        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {

                $manager->persist($sejour);
                $manager->flush();
                // faire message de succès addFlash
                return $this->redirectToRoute('app_index_index');
            } else {
                echo 'probleme';
            }

        }

        return $this->render(
            'admin/sejour/edit.html.twig',
            ['form' => $form->createView()]
        );
    }






}