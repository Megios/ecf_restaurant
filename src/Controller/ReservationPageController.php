<?php

namespace App\Controller;

use App\Entity\HoraireRestaurant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationPageController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }
        

        $date= [
            'now' => date("Y-m-d",time()),
            'maxResa' => date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")))
        ];
        return $this->render('reservation_page/index.html.twig', [
            'controller_name' => 'ReservationPageController',
            'date' => $date,
            'semaine' => $horaireSemaine
        ]);
    }
}
