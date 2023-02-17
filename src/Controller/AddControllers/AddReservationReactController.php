<?php

namespace App\Controller\AddControllers;

use App\Entity\User;
use App\Entity\Reservation;
use App\Service\EnvoyeurEmail;
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
      $dateResa = \DateTimeImmutable::createFromFormat('Y-n-d', substr($testform['Date'], 0, 10));
      $heureResa = \DateTimeImmutable::createFromFormat('H:i', $testform['Heure']);
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
      // $email = (new Email())
      //       ->from('ad.messaoudene@gefd.com')
      //       ->to('anissa.zagaye@efsfds.com')
      //       //->cc('cc@example.com')
      //       //->bcc('bcc@example.com')
      //       //->replyTo('fabien@example.com')
      //       //->priority(Email::PRIORITY_HIGH)
      //       ->subject('test!')
      //       ->text('Sending emails is fun again!')
      //       ->html('<p>See Twig integration for better HTML integration!</p>');
      // $mailer->send($email);
      $message = "Votre Reservation a bien été prit en compte, nous verrons donc bien le ".date_format($resa->getDate(),'d M Y')." a ". $resa->afficheHeure();
      $sendmail = new EnvoyeurEmail();
      $sendmail->sendMail($resa->getEmail(),"Reservation Confirmer", $message);
      return new JsonResponse(['Message' => 'L\'inscription s\'est bien dérouler', 'Error' => 'rentré dans la bouclee']);
    } else {
      return new JsonResponse(['Message' => 'Email déja utiliser', 'Error' => 'pas rentré dans la bouclee']);
    }
  }
}
