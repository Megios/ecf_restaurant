<?php

namespace App\Controller\AddControllers;

use App\Entity\Menu;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddMenuReactController extends AbstractController
{
    #[Route('/addMenu', name: 'addMenu')]
    public function index(Request $test, EntityManagerInterface $em)
    {
      if ($test->headers->get('content-type') === "application/json") {
        $testform = json_decode($test->getContent(), true);
        $menu = new Menu;
        $menu->setNom($testform['Titre']);
        $menu->setPrix(intval($testform['Prix']));
        $menu->setDescription($testform['Description']);
        $ind=intval($testform['Ordre']);
        while($em->getRepository(Menu::class)->findOneby(array('ordre' => $ind))){
          $em->getRepository(Menu::class)->findOneby(array('ordre' => $ind ))->setOrdre($ind+1);
          $ind++;
        }
        $menu->setOrdre(intval($testform['Ordre']));
        $em->persist($menu);
        $em->flush();
        return new JsonResponse(['Message' => 'L\'inscription s\'est bien dérouler','Error' => 'rentré dans la bouclee']);
    } else {
      return new JsonResponse(['Message' => 'Email déja utiliser','Error' => 'pas rentré dans la bouclee']);
    }



    }
}