<?php

namespace App\Controller\RemoveControllers;

use Exception;

use App\Entity\Carte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveCarteReactController extends AbstractController
{
  #[Route('/removeCarte', name: 'removeCarte')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $carte = $em->getRepository(Carte::class)->findOneby(array('id' => $id));
        $ind = $carte->getOrdre();
        $em->getRepository(carte::class)->remove($carte);
        //on remet l'ordre en place

        $tempCarte = $em->getRepository(Carte::class)->findOneby(array('ordre' => $ind + 1));
        while ($tempCarte) {
          $tempCarte->setOrdre($ind);
          $ind++;
          $tempCarte = $em->getRepository(Carte::class)->findOneby(array('ordre' => $ind + 1));
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
