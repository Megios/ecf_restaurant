<?php

namespace App\Controller\ModifyControllers;

use Exception;

use App\Entity\Carte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifyCarteReactController extends AbstractController
{
  #[Route('/modifyCarte', name: 'modifyCarte')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $carte = $em->getRepository(Carte::class)->findOneby(array('id' => $id));
        $carte->setNom($testform['Nom']);
        $ind = intval($testform['Ordre']);
        while ($ind > $carte->getOrdre()) {
          $temporyCard = $em->getRepository(Carte::class)->findOneby(array('ordre' => $carte->getOrdre() + 1));
          if ($temporyCard) {
            $temporyCard->setOrdre($carte->getOrdre());
          };
          $carte->setOrdre($carte->getOrdre() + 1);
        }
        while ($ind < $carte->getOrdre() && $carte->getOrdre() > 1) {
          $temporyCard = $em->getRepository(Carte::class)->findOneby(array('ordre' => $carte->getOrdre() - 1));
          if ($temporyCard) {
            $temporyCard->setOrdre($carte->getOrdre());
          };
          $carte->setOrdre($carte->getOrdre() - 1);
        }
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de carte trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de carte s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}
