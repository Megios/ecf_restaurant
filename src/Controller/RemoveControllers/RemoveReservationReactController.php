<?php

namespace App\Controller\RemoveControllers;

use Exception;

use App\Entity\Reservation;
use App\Service\EnvoyeurEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveReservationReactController extends AbstractController
{
  #[Route('/removeReservation', name: 'removeReservation')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $id = $testform['Id'];
      try {
        $Reservation = $em->getRepository(Reservation::class)->findOneby(array('uuid' => $id));
        if ($Reservation->isAnnulable()){
          $sendmail = new EnvoyeurEmail();
          $message = "Votre Reservation a bien été annulé, ce mail conscerne la reservation du  ".date_format($Reservation->getDate(),'d M Y')." a ". $Reservation->afficheHeure();
          $sendmail->sendMail($Reservation->getEmail(),"Reservation Annuler", $message);
          $em->getRepository(Reservation::class)->remove($Reservation);
          $em->flush();
          
          
          return new JsonResponse(['Message' => 'La suppresion de Reservation s\'est bien dérouler']);
        }
        else{
          return new JsonResponse(['Message' => 'La suppresion de Reservation n\'est pas possible']);
        }
        
      } catch (Exception $e) {
        return new JsonResponse(['Message' => 'Pas de Reservation trouvé', 'Error' => 'Json only']);
      }
    } else {
      return new JsonResponse(['Message' => 'PAs du bon type', 'Error' => 'Json only']);
    }
  }
}