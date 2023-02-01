<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartePageController extends AbstractController
{
    #[Route('/carte', name: 'app_carte_page')]
    public function index(): Response
    {
        $lundi = [
            'open' => true,
            'open_midi' => '12:00',
            'close_midi' => '14:00',
            'open_soir' => '17:00',
            'close_soir' => '22:00'
        ];
        $mardi = [
            'open' => true,
            'open_midi' => '12:00',
            'close_midi' => '14:00',
            'open_soir' => '17:00',
            'close_soir' => '22:00'
        ];
        $mercredi = [
            'open' => false,
        ];
        $jeudi = [
            'open' => true,
            'open_midi' => '12:00',
            'close_midi' => '14:00',
            'open_soir' => '17:00',
            'close_soir' => '22:00'
        ];
        $vendredi = [
            'open' => true,
            'open_midi' => '12:00',
            'close_midi' => '14:00',
            'open_soir' => '17:00',
            'close_soir' => '22:00'
        ];
        $samedi = [
            'open' => true,
            'open_midi' => '',
            'close_midi' => '',
            'open_soir' => '17:00',
            'close_soir' => '23:00'
        ];

        $dimanche = [
            'open' => true,
            'open_midi' => '12:00',
            'close_midi' => '16:00',
            'open_soir' => '',
            'close_soir' => ''
        ];
        $semaine = [
            'Lundi' => $lundi,
            'Mardi' => $mardi,
            'Mercredi' => $mercredi,
            'Jeudi' => $jeudi,
            'Vendredi' => $vendredi,
            'Samedi' => $samedi,
            'Dimanche' => $dimanche
        ];
        $plat = [
            'titre' => 'Sauté de veaux',
            'prix' => 1200,
            'categories' => 'Burgers'
        ];
        $repas = [
            'title' => 'Repas',
            'categories' => ['Entrées', 'Burgers', 'Plats', 'Desserts', "chameaux"],
            'Plats' => [$plat, [
                'titre' => 'Sauté de veaux',
                'prix' => 1200,
                'categories' => 'Plats'
            ],[
                'titre' => 'Sauté de veaux',
                'prix' => 1200,
                'categories' => 'Desserts'
            ],[
                'titre' => 'Sauté de veaux',
                'prix' => 1200,
                'categories' => 'Entrées'
            ],[
                'titre' => 'Anissa belle gosse',
                'prix' => 1200,
                'categories' => 'Desserts'
            ],[
                'titre' => 'Sauté de veaux',
                'prix' => 1200,
                'categories' => 'Desserts'
            ],[
                'titre' => 'Sauté de veaux',
                'prix' => 1200,
                'categories' => 'Desserts'
            ],[
                'titre' => 'Sauté de veaux',
                'prix' => 1200,
                'categories' => 'chameaux'
            ]
            ]
        ];
        
        $carte = [
            'repas' => $repas,
            'boisson' => $repas,
        
        ];
        return $this->render('carte_page/index.html.twig', [
            'controller_name' => 'CartePageController',
            'semaine' => $semaine,
            'cartes' => $carte
        ]);
    }
}
