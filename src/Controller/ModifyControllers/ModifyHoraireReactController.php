<?php

namespace App\Controller\ModifyControllers;

use App\Entity\HoraireRestaurant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifyHoraireReactController extends AbstractController
{
  #[Route('/modifyHoraire', name: 'modifyHoraire')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = intval($testform['Id']);
      $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('id' => $id));
      $horaire->setJour($testform['Jour']);
      $horaire->setOuvert($testform['Ouvert']);

      if ($testform['OpenMidi']) {
        $horaire->setOpenMidi(\DateTimeImmutable::createFromFormat('H:i', $testform['OuvertureMidi']));
        $horaire->setCloseMidi(\DateTimeImmutable::createFromFormat('H:i', $testform['FermetureMidi']));
      } else {
        $horaire->setOpenMidi(null);
        $horaire->setCloseMidi(null);
      }
      if ($testform['OpenSoir']) {
        $horaire->setOpenSoir(\DateTimeImmutable::createFromFormat('H:i', $testform['OuvertureSoir']));
        $horaire->setCloseSoir(\DateTimeImmutable::createFromFormat('H:i', $testform['FermetureSoir']));
      } else {
        $horaire->setOpenSoir(null);
        $horaire->setCloseSoir(null);
      }
      $em->persist($horaire);
      $em->flush();
      return new JsonResponse(['Message' => 'L\'ajout de Horaire s\'est bien dérouler']);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}
