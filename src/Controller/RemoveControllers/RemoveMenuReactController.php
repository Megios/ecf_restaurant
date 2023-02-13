<?php

namespace App\Controller\RemoveControllers;

use Exception;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveMenuReactController extends AbstractController
{
  #[Route('/removeMenu', name: 'removeMenu')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      try {
        $menu = $em->getRepository(Menu::class)->findOneby(array('id' => $id));
        $ind= $menu->getOrdre();
        $em->getRepository(Menu::class)->remove($menu);
        //on remet l'ordre en place

        $tempMenu= $em->getRepository(Menu::class)->findOneby(array('ordre' => $ind+1));
        while($tempMenu){
          $tempMenu->setOrdre($ind);
          $ind++;
          $tempMenu= $em->getRepository(Menu::class)->findOneby(array('ordre' => $ind+1));
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
