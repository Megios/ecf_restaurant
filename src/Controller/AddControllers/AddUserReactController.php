<?php

namespace App\Controller\AddControllers;

use App\Entity\User;

use App\Service\EnvoyeurEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AddUserReactController extends AbstractController
{
    #[Route('/addUser', name: 'addUser')]
    public function index(Request $test, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        if ($test->headers->get('content-type') === "application/json") {
            $testform = json_decode($test->getContent(), true);
            if ($em->getRepository(User::class)->findby(array('email' => $testform['Email']))) {
                return new JsonResponse(['Message' => 'Email déja utiliser']);
            } else {
                $user = new User();

                // hash the password (based on the security.yaml config for the $user class)
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $testform['MotDePasse']
                );
                $user->setPassword($hashedPassword);
                $user->setEmail($testform['Email']);
                $user->setNumeroTel($testform['Num']);
                $user->setPassword($hashedPassword);
                $user->setCouvertDefault(intval($testform['Couverts']));
                $user->setReservationName($testform['Nom']);
                $user->setAllergene($testform['Allergene']);
                if($em->getRepository(User::class)->findAll()===[]){
                    $user->setRoles(['ROLE_ADMIN']);
                }
                $em->persist($user);
                $em->flush();
                $message = "Bienvenu ".$user->getReservationName()." nous esperons vous apprecierez mangez chez nous !  ";
                $sendmail = new EnvoyeurEmail();
                $sendmail->sendMail($user->getEmail(),"Bienvenue chez Quai Antique", $message);
                return new JsonResponse(['Message' => 'L\'inscription s\'est bien dérouler']);
            }
        } else {
            return $this->redirectToRoute('app_home_page');
        }
    }
}