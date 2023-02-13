<?php

namespace App\Controller\RemoveControllers;

use Exception;

use App\Entity\HoraireRestaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveHoraireReactController extends AbstractController
{
  #[Route('/removeHoraire', name: 'removeHoraire')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $Horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('id' => $id));
        $em->getRepository(HoraireRestaurant::class)->remove($Horaire);
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de Horaire trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de Horaire s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}