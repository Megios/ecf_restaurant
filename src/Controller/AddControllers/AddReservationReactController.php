<?php

namespace App\Controller\AddControllers;

use App\Entity\User;
use App\Entity\Reservation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddReservationReactController extends AbstractController
{
  #[Route('/addResa', name: 'addResa')]
  public function index(Request $test, EntityManagerInterface $em)
  {
    if ($test->headers->get('content-type') === "application/json") {
      $testform = json_decode($test->getContent(), true);
      $resa = new Reservation();
      if (isset($testform['User']) && $em->getRepository(User::class)->findBy(array('email' => $testform['User']))) {
        $user = $em->getRepository(User::class)->findOneBy(array('email' => $testform['User']));
        $resa->setAccount($user);
      }
      $dateResa = \DateTimeImmutable::createFromFormat('Y-n-d',substr($testform['Date'],0,10));
      $heureResa= \DateTimeImmutable::createFromFormat('H:i',$testform['Heure']);
      var_dump('userTrouver');
      $resa->setNomReservation($testform['Nom']);
      $resa->setEmail($testform['Email']);
      $resa->setNumeroReservation($testform['Num']);
      $resa->setDate($dateResa);
      $resa->setCouvert(intval($testform['Couverts']));
      $resa->setAllergene($testform['Allergene']);
      $resa->setCommentaire($testform['Commentaire']);
      $resa->setHeure($heureResa);
      $resa->setUuid(uniqid());
      
      $em->persist($resa);
      $em->flush();
      return new JsonResponse(['Message' => 'L\'inscription s\'est bien dérouler','Error' => 'rentré dans la bouclee']);
    } else {
      return new JsonResponse(['Message' => 'Email déja utiliser','Error' => 'pas rentré dans la bouclee']);
    }
  }
}
