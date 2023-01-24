<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuPageController extends AbstractController
{
    #[Route('/menu', name: 'app_menu_page')]
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

        $menu1 = [
            'title' => 'un menu express',
            'description' => 'c\'est un menu avec plein de bonne chose',
            'price' => 2000
        ];
        $menu2 = [
            'title' => 'un menu midi',
            'description' => 'c\'est un menu avec plein de bonne chose',
            'price' => 2500
        ];
        $menu3 = [
            'title' => 'un menu complet',
            'description' => 'c\'est un menu avec plein de bonne chose et tu sors le ventre vraiment très très vide ',
            'price' => 3500
        ];
        $menus = [
            1 => $menu1,
            2 => $menu2,
            3 => $menu3
        ];
        return $this->render('menu_page/index.html.twig', [
            'controller_name' => 'MenuPageController',
            'semaine' => $semaine,
            'menus' => $menus
        ]);
    }
}
