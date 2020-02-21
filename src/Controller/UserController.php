<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController

{
    /**
     * @Route("/inscription")
     */
    public function register
    (Request $request,
     UserPasswordEncoderInterface $passwordEncoder,
     EntityManagerInterface $manager
    )
    {
        $user = new User();
        $user->setPremium(0); // on set le nouveau user en non premium
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $encodePassword = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
                $user->setPassword($encodePassword);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Votre compte est créé');
                return $this->redirectToRoute('app_index_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('user/register.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/connexion")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        /*if(empty($error)){
            $this->addFlash('success','vous etes connécte');
        }*/

        if(!empty($error)){
            $this->addFlash('error', 'Identifiants incorrects');
        }

        return $this->render(
            'user/login.html.twig',
            ['last_username'=> $lastUsername]
        );
    }
    /**
     * @Route("/deconnexion")
     */
    public function logout(){

    }

    /**
     * Affiche la page mon compte avec possibilité de modifier mes infos
     * @Route("/info")
     */
    public function profil(UserRepository $userRepository)
    {
        return $this->render('user/index.html.twig');
    }

    /**
     *@Route("/update")
     */
    public function update(Request $request, EntityManagerInterface $manager,  UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = $this->getUser();
        /*$password = $user->getPassword();
        $user->setPassword($password);*/
        // dd($user); Comment renvoyer le password?

        $form = $this->createForm(UpdateType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $encodePassword = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
                $user->setPassword($encodePassword);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Votre compte est mis à jour');
                return $this->redirectToRoute('app_index_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('user/update.html.twig',
            ['form'=>$form->createView()]);
    }




    /**
     * @Route("/edition/{id}", defaults={"id":null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {


            $sejour = $manager->find(Sejour::class, $id);


        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
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





}