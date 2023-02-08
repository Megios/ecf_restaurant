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
        // $menu1 = [
        //     'title' => 'un menu express',
        //     'description' => 'c\'est un menu avec plein de bonne chose',
        //     'price' => 2000
        // ];
        // $menu2 = [
        //     'title' => 'un menu midi',
        //     'description' => 'c\'est un menu avec plein de bonne chose',
        //     'price' => 2500
        // ];
        // $menu3 = [
        //     'title' => 'un menu complet',
        //     'description' => 'c\'est un menu avec plein de bonne chose et tu sors le ventre vraiment très très vide ',
        //     'price' => 3500
        // ];
        // $menus = [
        //     1 => $menu1,
        //     2 => $menu2,
        //     3 => $menu3
        // ];
        // var_dump($menus);
        return $this->render('menu_page/index.html.twig', [
            'controller_name' => 'MenuPageController',
            'semaine' => $horaireSemaine,
            'menus' => $menuTest
        ]);
    }
}
