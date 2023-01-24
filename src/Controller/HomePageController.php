<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
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

        $photo =[
            'format' => 'portrait',
            'source' =>'./image/test.png',
            'title' => 'Test image'
        ];
        $photop = [
            'format' => 'paysage',
            'source' =>'./image/testpaysage.jpg',
            'title' => 'Test image'

        ];
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'semaine' => $semaine,
            'photo' => $photo,
            'photop' => $photop
        ]);
    }
}
