<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginPageController extends AbstractController
{
    #[Route('/login', name: 'app_login_page')]
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
        return $this->render('login_page/index.html.twig', [
            'controller_name' => 'LoginPageController',
            'semaine' => $semaine,
        ]);
    }
}
