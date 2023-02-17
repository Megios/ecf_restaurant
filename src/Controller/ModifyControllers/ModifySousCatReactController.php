<?php

namespace App\Controller\ModifyControllers;

use Exception;
use App\Entity\Carte;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifySousCatReactController extends AbstractController
{
  #[Route('/modifySousCat', name: 'modifySousCat')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $sousCat = $em->getRepository(SousCategorie::class)->findOneby(array('id' => $id));
        $carte = $em->getRepository(Carte::class)->findOneby(array('nom' => $testform['Carte']));
        $sousCat->setNom($testform['Nom']);
        $sousCat->setCarte($carte);
        $ind = intval($testform['Ordre']);
        while ($ind > $sousCat->getOrdre()) {
          $temporyCard = $em->getRepository(SousCategorie::class)->findOneby(array('carte' => $carte, 'ordre' => $sousCat->getOrdre() + 1));
          if ($temporyCard) {
            $temporyCard->setOrdre($sousCat->getOrdre());
          };
          $sousCat->setOrdre($sousCat->getOrdre() + 1);
        }
        while ($ind < $sousCat->getOrdre() && $sousCat->getOrdre() > 1) {
          $temporyCard = $em->getRepository(SousCategorie::class)->findOneby(array('carte' => $carte, 'ordre' => $sousCat->getOrdre() - 1));
          if ($temporyCard) {
            $temporyCard->setOrdre($sousCat->getOrdre());
          };
          $sousCat->setOrdre($sousCat->getOrdre() - 1);
        }
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de sousCategorie trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de la catégorie s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}
