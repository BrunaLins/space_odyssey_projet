<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Hebergement;
use App\Entity\Sejour;
use App\Entity\User;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommandeController
 * @package App\Controller
 *
 * @Route("/info")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(CommandeRepository $repository)
    {
        $user = $this->getUser();
        $commandes = $repository->findBy(
            ['user' => $user],
            ['id' => 'ASC']
        );
        // dump($commandes);


        return $this->render('user/index.html.twig',
            ['commandes' => $commandes]);
    }

    /**
     * @Route("/commande")
     */
    public function passecommande(SessionInterface $session, EntityManagerInterface $manager)
    {
        $commande = new Commande();
        // il faut récuperer le userid(session), le nbre de personnes, le prixfinal (on le passe dans un form caché)
        // la date de commande est settee à aujourd'hui
        $commande
            ->setUser($this->getUser());

        $prixTotal = 0;
        foreach ($session->get('panier') as $sejourId => $nbPersonne) {
            $sejour = $manager->getRepository(Sejour::class)->find($sejourId);
            $prix = $sejour->getPrixSejour() * $nbPersonne;
            if (!empty($sejour->getPromo())) {
                $remise = $prix * ($sejour->getPromo() / 100);
                $prix -= $remise;
            }
            $prixTotal += $prix;
        }

        $commande
            ->setPrixFinal($prixTotal);

        $manager->persist($commande);
        $manager->flush();

        $this->addFlash('success', 'La commande est passée');
        $session->clear();

       return $this->redirectToRoute('app_commande_index');
    }



}
