<?php

namespace App\Controller;

use Exception;
use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Carte;
use App\Entity\Produit;
use App\Entity\Reservation;
use App\Entity\SousCategorie;
use App\Entity\HoraireRestaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPageController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_page')]
    public function index(EntityManagerInterface $em,UserInterface $userD): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir(),'id' =>$jour->getId()];
        }
        $user = $em->getRepository(User::class)->findby(array('email' => $userD->getUserIdentifier()));
        try{
            $reservations = $em->getRepository(Reservation::class)->findAll(array());
        }catch(Exception $e ){
            $reservations=null;
        }
        $menus = $em->getRepository(Menu::class)->findby(array(),array('ordre' => 'asc'));
        $cartes = $em->getRepository(Carte::class)->findby(array(),array('ordre' => 'asc'));
        // $sousCats= $em->getRepository(SousCategorie::class)->findby(array(),array('nom'=> 'asc'),array('ordre' => 'asc'));
        $sousCats=$em->getRepository(SousCategorie::class)->findAllTrier();
        $tabSousCats = [];
        foreach ($cartes as $carte) {
            $objets=[ 'nom' => $carte->getNom(),'ordre' => $carte->getOrdre()];
            array_push($tabSousCats,$objets);
            # code...
        }
        $tabProduits = [];
        $parentProduits =[];
        foreach($sousCats as $sousCat){
            $objets=['parent'=> $sousCat->getCarte()->getNom(),'nom'=> $sousCat->getNom()];
            array_push($tabProduits,$objets);
            if(!in_array($objets['parent'],$parentProduits)){
                array_push($parentProduits,$objets['parent']);
            };
        }
        $produits=$em->getRepository(Produit::class)->findAllTrier();
        return $this->render('admin_page/index.html.twig', [
            'controller_name' => 'AdminPageController',
            'semaine' => $horaireSemaine,
            'reservations' => $reservations,
            'menus' => $menus,
            'cartes' => $cartes,
            'cartesA' => $tabSousCats,
            'sousCats' => $sousCats,
            'sousCatsA'=> $tabProduits,
            'parents' => $parentProduits,
            'produits' => $produits
        ]);
    }
}
