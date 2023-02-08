<?php

namespace App\Controller;

use App\Entity\HoraireRestaurant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }

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
            'semaine' => $horaireSemaine,
            'photo' => $photo,
            'photop' => $photop
        ]);
    }
}
