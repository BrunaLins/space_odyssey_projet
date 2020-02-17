<?php


namespace App\Controller\Admin;


use App\Entity\Sejour;
use App\Form\SejourType;
use App\Repository\SejourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @Route("/edition/{id}", defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        $originalImage1 = null;

        if(is_null($id)) {
            $sejour = new Sejour();
        } else { // on recupère le séjour et on le modifie
            $sejour = $manager->find(Sejour::class, $id);

            if(is_null($sejour)) {
                throw new NotFoundHttpException();
            }

            if(!is_null($sejour->getImage1())) {
                // nom du fichier venant de la bdd
                $originalImage1 = $sejour->getImage1();

                // on sette 'image avec un objet File pour le champ formulaire
                $sejour->setImage1(
                    new File($this->getParameter('upload_dir'). $originalImage1)
                );
            }

        }

        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {

                /** @var UploadedFile|null $image1 */
                $image1 = $sejour->getImage1();

                // s'il y a eu une iamge uploadée
                if (!is_null($image1)) {
                    // nom sous lequel on va enregistrer l'image dans la base
                    $filename = uniqid() . '.' . $image1->guessExtension();
                    $image1->move(
                    // répertoire de destination
                    // cf/config/services.yaml
                        $this->getParameter('upload_dir'),
                        // nom du fichier
                        $filename
                    );

                    // on set l'image du sejour avec le nom du fichier pour enregistrement en bdd
                    $sejour->setImage1($filename);

                    // en modification, on supprime l'ancienne image s'il y en a une
                    if (!is_null($originalImage1)) {
                        unlink($this->getParameter('upload_dir'). $originalImage1);
                    }
                } else {
                    // en modification, sans upload, on sette l'image avec le nom de l'ancienne image
                    $sejour->setImage1($originalImage1);
                }

                $manager->persist($sejour);
                $manager->flush();
                $this->addFlash('success', 'Le séjour est enregistré');
                return $this->redirectToRoute('app_admin_sejour_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'admin/sejour/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/suppression/{id}", requirements={"id": "\d+"})
     */
    public function delete(EntityManagerInterface $manager, Sejour $sejour)
    {
        $manager->remove($sejour);
        $manager->flush();

        $this->addFlash('success', 'Le sejour est supprimé');

        return $this->redirectToRoute('app_admin_sejour_index');
    }





}