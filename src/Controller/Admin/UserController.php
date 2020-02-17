<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller\Admin
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(UserRepository $repository)
    {
        $users = $repository->findBy(
            [], ['id'=>'ASC']);
        dump($users);

        return $this->render(
            'admin/user/index.html.twig',
            ['users' => $users]
        );
    }

    /**
     * @Route("/edition/{id}", defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        if(is_null($id)){
            $user = new User();
        } else {
            $user = $manager->find(User::class, $id);
            $user->setPremium(1); // on set le user en premium

            if(is_null($user)) {
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {

                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Le user est passé en premium');
                return $this->redirectToRoute('app_admin_user_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'admin/user/edit.html.twig',
            ['form' => $form->createView()]
        );
    }



}