<?php

namespace App\Controller\ModifyControllers;

use Exception;
use App\Entity\Carte;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifyProduitReactController extends AbstractController
{
    #[Route('/modifyProduit', name: 'modifyProduit')]
    public function index(Request $test, EntityManagerInterface $em)
    {
      if ($test->headers->get('content-type') === "application/json") {
        $testform = json_decode($test->getContent(), true);
        $id = intval($testform['Id']);
        try {
          $produit = $em->getRepository(produit::class)->findOneby(array('id' => $id));
          $produit->setNom($testform['Nom']);
          $produit->setPrix(intval($testform['Prix']));
          $ind = intval($testform['Ordre']);
          $sousCat = $em->getRepository(SousCategorie::class)->findOneby(array('nom' => $testform['SousCategorie']));
          if($sousCat === $produit->getSousCategorie()){
            while ($ind > $produit->getOrdre()) {
              $temporyCard = $em->getRepository(produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $produit->getOrdre() + 1));
              if ($temporyCard) {
                $temporyCard->setOrdre($produit->getOrdre());
              };
              $produit->setOrdre($produit->getOrdre() + 1);
            }
            while ($ind < $produit->getOrdre() && $produit->getOrdre() > 1) {
              $temporyCard = $em->getRepository(produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $produit->getOrdre() - 1));
              if ($temporyCard) {
                $temporyCard->setOrdre($produit->getOrdre());
              };
              $produit->setOrdre($produit->getOrdre() - 1);
            }
          }else{
            //On remet en ordre dans la catégorie initial
            $temporyCard = $em->getRepository(produit::class)->findOneby(array('sousCategorie' => $produit->getSousCategorie(),'ordre' => $produit->getOrdre() + 1));
            while ($temporyCard) {
              $temporyCard->setOrdre($temporyCard->getOrdre()-1);
              $temporyCard = $em->getRepository(produit::class)->findOneby(array('sousCategorie' => $temporyCard->getSousCategorie(),'ordre' => $temporyCard->getOrdre() + 2));
            };
            //On met de l'ordre dans la nouvelle catégorie
            while ($em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind))) {
              $em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind ))->setOrdre($ind+1);
              $ind++;
          }
            $produit->setSousCategorie($sousCat);
            $produit->setOrdre(intval($testform['Ordre']));


          }
          $em->flush();
        } catch (Exception $e) {
          return new JsonResponse(['Message' => 'Pas de produit trouvé', 'Error' => 'Json only']);
        }
        return new JsonResponse(['Message' => 'L\'ajout de produit s\'est bien dérouler']);
      } else {
        return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
      }
        // if ($test->headers->get('content-type') === "application/json") {
        //     $testform = json_decode($test->getContent(), true);
            
        //     $produit = new Produit();
        //     $produit->setNom($testform['Nom']);
        //     $produit->setPrix(intval($testform['Prix']));
        //     $ind=intval($testform['Ordre']);
        //     $sousCat = $em->getRepository(SousCategorie::class)->findOneby(array('nom' => $testform['SousCategorie']));
        //     while ($em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind))) {
        //         $em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind ))->setOrdre($ind+1);
        //         $ind++;
        //     }
        //     $produit->setOrdre(intval($testform['Ordre']));
        //     $produit->setSousCategorie($sousCat);
        //     $em->persist($produit);
        //     $em->flush();
        //     return new JsonResponse(['Message' => 'L\'ajout de la catégorie s\'est bien dérouler']);
        // } else {
        //     return new JsonResponse(['Message' => 'PAs du bon type','Error' => 'Json only']);
        // }
    }
}