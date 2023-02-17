<?php

namespace App\Controller;

use App\Entity\HoraireRestaurant;
use App\Entity\Menu;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuPageController extends AbstractController
{
    #[Route('/menu', name: 'app_menu_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $test = $em->getRepository(Menu::class)->findAll();
        $menuTest = [];
        foreach ($test as $produit) {
            $menu = [
                'title' => $produit->getNom(), 'description' => $produit->getDescription(),
                'price' => $produit->getPrix()
            ];
            array_push($menuTest, $menu);
        }
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jourss) {
            $horaireSemaine[$jourss->getJour()] = ['open' => $jourss->isOuvert(), 'open_midi' => $jourss->getOpenMidi(), 'close_midi' => $jourss->getCloseMidi(), 'open_soir' => $jourss->getOpenSoir(), 'close_soir' => $jourss->getCloseSoir()];
        }
        return $this->render('menu_page/index.html.twig', [
            'controller_name' => 'MenuPageController',
            'semaine' => $horaireSemaine,
            'menus' => $menuTest
        ]);
    }
}
