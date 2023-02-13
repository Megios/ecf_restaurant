<?php

namespace App\Controller\RemoveControllers;

use Exception;

use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveSousCatReactController extends AbstractController
{
  #[Route('/removeSousCat', name: 'removeSousCat')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $SousCat = $em->getRepository(SousCategorie::class)->findOneby(array('id' => $id));
        $carte =$SousCat->getCarte();
        $ind = $SousCat->getOrdre();
        $em->getRepository(SousCategorie::class)->remove($SousCat);
        //on remet l'ordre en place

        $tempSousCat = $em->getRepository(SousCategorie::class)->findOneby(array('carte' => $carte,'ordre' => $ind + 1));
        while ($tempSousCat) {
          $tempSousCat->setOrdre($ind);
          $ind++;
          $tempSousCat = $em->getRepository(SousCategorie::class)->findOneby(array('carte' => $carte,'ordre' => $ind + 1));
        }
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de SousCat trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de SousCat s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}