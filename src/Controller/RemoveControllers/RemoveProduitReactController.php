<?php

namespace App\Controller\RemoveControllers;

use Exception;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveProduitReactController extends AbstractController
{
  #[Route('/removeProduit', name: 'removeProduit')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $Produit = $em->getRepository(Produit::class)->findOneby(array('id' => $id));
        $sousCat =$Produit->getSousCategorie();
        $ind = $Produit->getOrdre();
        $em->getRepository(Produit::class)->remove($Produit);
        //on remet l'ordre en place

        $tempProduit = $em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind + 1));
        while ($tempProduit) {
          $tempProduit->setOrdre($ind);
          $ind++;
          $tempProduit = $em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind + 1));
        }
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de Produit trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de Produit s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}