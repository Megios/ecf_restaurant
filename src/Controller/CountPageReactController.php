<?php

namespace App\Controller;


use App\Entity\HoraireRestaurant;
use App\Entity\Reservation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CountPageReactController extends AbstractController
{
  #[Route('/getCount', name: 'getCount')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('accept') === "application/json, text/plain, */*") {
      $timeeS = $test->get('slug');
      $timeS = \DateTime::createFromFormat('Y-n-d',substr($timeeS,0,10));
      $timeS = date_timestamp_get($timeS);
      $info = getdate($timeS);
      switch ($info["wday"]) {
        case 0:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Dimanche'));
          break;
        case 1:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Lundi'));
          break;
        case 2:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Mardi'));
          break;
        case 3:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Mercredi'));
          break;
        case 4:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Jeudi'));
          break;
        case 5:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Vendredi'));
          break;
        case 6:
          $horaire = $em->getRepository(HoraireRestaurant::class)->findOneby(array('jour' => 'Samedi'));
          break;
        default:
          $horaire = null;
          break;
      }
      if ($horaire !== null) {
        $dateResaDebut = new DateTime();
        $dateResaDebut->setTimestamp($timeS);
        $dateResaFin = new DateTime() ;
        $dateResaFin->setTimestamp($timeS);
        if($horaire->getOpenMidi()===null){
          $nombreCouvertMidi=0;
        }else{
          $test = getdate(date_timestamp_get($horaire->getOpenMidi()));
          $dateResaDebut->setTime(
            $test["hours"],
            $test["minutes"]
          );
          $test = getdate(date_timestamp_get($horaire->getCloseMidi()));
          $dateResaFin->setTime(
            $test["hours"],
            $test["minutes"]
          );
          $nombreCouvertMidi = $em->getRepository(Reservation::class)->couvertDisponible($dateResaDebut, $dateResaFin);
        }
        if($horaire->getOpenSoir()!== null){
          $test = getdate(date_timestamp_get($horaire->getOpenSoir()));
          $dateResaDebut->setTime(
            $test["hours"],
            $test["minutes"]
          );
          $test = getdate(date_timestamp_get($horaire->getCloseSoir()));
          $dateResaFin->setTime(
            $test["hours"],
            $test["minutes"]
          );
          $nombreCouvertSoir = $em->getRepository(Reservation::class)->couvertDisponible($dateResaDebut, $dateResaFin);
        }else{
          $nombreCouvertSoir=0;
        }
      } else {
        $nombreCouvertSoir = 0;
        $nombreCouvertMidi = 0;
      }
      return new JsonResponse(['midi' => $nombreCouvertMidi, 'soir' => $nombreCouvertSoir, 'time'=> $info, 'debut' => $dateResaDebut, 'fin' => $dateResaFin]);
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}
