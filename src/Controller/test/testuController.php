<?php

namespace App\Controller\test;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class testuController extends AbstractController
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
                $em->persist($user);
                $em->flush();
                return new JsonResponse(['Message' => 'L\'inscription s\'est bien dérouler']);
            }
        } else {
            return $this->redirectToRoute('app_home_page');
        }
    }
}