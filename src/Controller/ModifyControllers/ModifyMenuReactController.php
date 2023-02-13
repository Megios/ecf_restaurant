<?php

namespace App\Controller\ModifyControllers;

use Exception;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifyMenuReactController extends AbstractController
{
  #[Route('/modifyMenu', name: 'modifyMenu')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $menu = $em->getRepository(Menu::class)->findOneby(array('id' => $id));
        $menu->setNom($testform['Nom']);
        $menu->setPrix(intval($testform['Prix']));
        $menu->setDescription($testform['Description']);
        $ind = intval($testform['Ordre']);
        while ($ind > $menu->getOrdre()) {
          $temporyCard = $em->getRepository(Menu::class)->findOneby(array('ordre' => $menu->getOrdre() + 1));
          if ($temporyCard) {
            $temporyCard->setOrdre($menu->getOrdre());
          };
          $menu->setOrdre($menu->getOrdre() + 1);
        }
        while ($ind < $menu->getOrdre() && $menu->getOrdre() > 1) {
          $temporyCard = $em->getRepository(Menu::class)->findOneby(array('ordre' => $menu->getOrdre() - 1));
          if ($temporyCard) {
            $temporyCard->setOrdre($menu->getOrdre());
          };
          $menu->setOrdre($menu->getOrdre() - 1);
        }
        $em->flush();
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de menu trouvé', 'Error' => 'Json only']);
      }
      return new JsonResponse(['Message' => 'L\'ajout de menu s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}
