<?php

namespace App\Controller;

use App\Entity\Carte;
use Exception;
use App\Entity\Produit;
use App\Entity\HoraireRestaurant;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartePageController extends AbstractController
{
    #[Route('/carte', name: 'app_carte_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }
        try {
            $produits = $em->getRepository(Produit::class)->findAllTrier();
            $cartes = $em->getRepository(Carte::class)->findAll(array(), array('ordre', 'asc'));
        } catch (Exception $e) {
            $produits = null;
        }
        $carte = [];
        foreach ($cartes as $cart) {
            $catCollections = $cart->getSousCategories();
            $catTab = [];
            $platTab = [];
            foreach ($catCollections as $catCollection) {
                try {
                    $produits = $catCollection->getProduits();
                    $count = 0;
                    foreach ($produits as $produit) {
                        $plat = ['titre' => $produit->getNom(), 'categories' => $produit->getSousCategorie()->getNom(), 'prix' => $produit->affichePrix()];
                        array_push($platTab, $plat);
                        $count++;
                    }
                    if ($count > 0) {
                        array_push($catTab, $catCollection->getNom());
                    }
                } catch (Exception $e) {
                }
            }
            // foreach($produits as $produit){
            //     if(in_array($produit->getSousCategorie()->getNom(),$catTab)){
            //         $plat=['titre' => $produit->getNom(),'categories' => $produit->getSousCategorie()->getNom(),'prix' => $produit->affichePrix()];
            //         array_push($platTab,$plat);
            //     }
            // }
            $nom = [
                'title' => $cart->getNom(),
                'categories' => $catTab,
                'Plats' => $platTab
            ];
            if(count($catTab)>0){
                array_push($carte, ['Carte' => $nom]);
            }
        }
        //carte= ["Repas","Boisson"]
        // $plat = [
        //     'titre' => 'Sauté de veaux',
        //     'prix' => 1200,
        //     'categories' => 'Burgers'
        // ];
        // $repas = [
        //     'title' => 'Repas',
        //     'categories' => ['Entrées', 'Burgers', 'Plats', 'Desserts', "chameaux"],
        //     'Plats' => [$plat, [
        //         'titre' => 'Sauté de veaux',
        //         'prix' => 1200,
        //         'categories' => 'Plats'
        //     ],[
        //         'titre' => 'Sauté de veaux',
        //         'prix' => 1200,
        //         'categories' => 'Desserts'
        //     ],[
        //         'titre' => 'Sauté de veaux',
        //         'prix' => 1200,
        //         'categories' => 'Entrées'
        //     ],[
        //         'titre' => 'Anissa belle gosse',
        //         'prix' => 1200,
        //         'categories' => 'Desserts'
        //     ],[
        //         'titre' => 'Sauté de veaux',
        //         'prix' => 1200,
        //         'categories' => 'Desserts'
        //     ],[
        //         'titre' => 'Sauté de veaux',
        //         'prix' => 1200,
        //         'categories' => 'Desserts'
        //     ],[
        //         'titre' => 'Sauté de veaux',
        //         'prix' => 1200,
        //         'categories' => 'chameaux'
        //     ]
        //     ]
        // ];

        // $carte = [
        //     'repas' => $repas,
        //     'boisson' => $repas,

        // ];
        return $this->render('carte_page/index.html.twig', [
            'controller_name' => 'CartePageController',
            'semaine' => $horaireSemaine,
            'cartes' => $carte
        ]);
    }
}
