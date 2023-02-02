<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_page')]
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
        return $this->render('admin_page/index.html.twig', [
            'controller_name' => 'AdminPageController',
            'semaine' => $semaine,
        ]);
    }
}