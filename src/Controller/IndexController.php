<?php

namespace App\Controller;


use App\Entity\Destination;
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

        $sejours = $repository2->findByPremium(
            $this->getUser() ? $this->getUser()->getPremium() : false
    );
        dump($sejours);

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


    /**
     * Creation du panier
     * @Route("/panier")
     */
    public function panier(SessionInterface $session,SejourRepository $sejourRepository)
    {
        $panier = $session->get('panier',[]);

        $panierPlein = [];
        //recupérer les info du séjour choisit
        foreach ($panier as $id => $quantite){
            $panierPlein[] = [
                'sejour'=>$sejourRepository->find($id),
                'quantite'=>$quantite
            ];
        } // dd($panier);

        $total = 0;
        $promo =0;

        // calculer le prix du séjour et faire le total
        foreach ($panierPlein as $sjr){
            $totalsjr = $sjr['sejour']->getPrixSejour() *$sjr['quantite'];
            $total += $totalsjr;
        }
        // calcul de la promo
        foreach ($panierPlein as $sjr){
            $promosjr= ($sjr['sejour']->getPrixSejour() *$sjr['quantite'])*(($sjr['sejour']->getPromo())/100);
            $promo += $promosjr;
        }
        // calcul du prix total par sejour
        /*foreach ($panierPlein as $sjr){
            $totalsjr = ($totalsjr - $promosjr) ;
        }*/

        // calcul du prix total du séjour après promo
        $total = $total - $promo;

        return $this->render('index/panier.html.twig',
            ['sjrs'=>$panierPlein,'total'=>$total]);
    }

    /**
     * Ajout quantité sejour dans le panier
     * @Route("/panier/add/{id}")
     */
    public function add(SessionInterface $session,$id)
    {
        $panier = $session->get('panier',[]);
        //incrémentation du séjour dans le panier
        if (!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }
        $session->set('panier',$panier);

        return $this->redirectToRoute('app_index_panier');
    }


    /**
     * Retire quantité sejour dans le panier
     * @Route("/panier/retire/{id}")
     */
    public function retire(SessionInterface $session,$id)
    {
        $panier = $session->get('panier',[]);
        //décrementation du séjour dans le panier
        if (!empty($panier[$id])){
            $panier[$id]--;
        }else{
            $panier[$id]=1;
        }
        $session->set('panier',$panier);
        // dump($session);

        return $this->redirectToRoute('app_index_panier');
    }


    /**
     * Supprimer un produit du panier
     * @Route("/panier/supprimer/{id}")
     */
    public function supprimerSejour($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);

        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        //mettre le panier à jour après suppression
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_index_panier');
    }







}
