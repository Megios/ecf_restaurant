<?php

namespace App\Controller\ModifyControllers;

use App\Entity\Galerie;
use Exception;

use App\Entity\image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifyGalerieReactController extends AbstractController
{
  #[Route('/modifyGalerie', name: 'modifyGalerie')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = $testform['Uuid'];
      try {
        $image = $em->getRepository(Galerie::class)->findOneby(array('uuid' => $id));
        $image->setTitre($testform['Titre']);
        $image->setFormat($testform['Format']);
        $ind = intval($testform['Ordre']);
        while ($ind > $image->getOrdre()) {
          $temporyImage = $em->getRepository(Galerie::class)->findOneby(array('ordre' => $image->getOrdre() + 1));
          if ($temporyImage) {
            $temporyImage->setOrdre($image->getOrdre());
          };
          $image->setOrdre($image->getOrdre() + 1);
        }
        while ($ind < $image->getOrdre() && $image->getOrdre() > 1) {
          $temporyImage = $em->getRepository(Galerie::class)->findOneby(array('ordre' => $image->getOrdre() - 1));
          if ($temporyImage) {
            $temporyImage->setOrdre($image->getOrdre());
          };
          $image->setOrdre($image->getOrdre() - 1);
        }
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de image trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de image s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}
