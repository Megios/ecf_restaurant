<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Reservation;

use App\Entity\HoraireRestaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountPageController extends AbstractController
{
    #[Route('/account', name: 'app_account_page')]
    public function index(EntityManagerInterface $em, UserInterface $userD): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();

        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }

        $user = $em->getRepository(User::class)->findby(array('email' => $userD->getUserIdentifier()));

        try {
            $reservations = $em->getRepository(Reservation::class)->findby(array('account' => $user[0]->getId()),array('date'=>'ASC'));
        } catch (Exception $e) {
            $reservations = null;
        }




        return $this->render('account_page/index.html.twig', [
            'controller_name' => 'AccountPageController',
            'semaine' => $horaireSemaine,
            'info' => $user,
            'resas' => $reservations
        ]);
    }
}
