<?php

namespace App\Controller\AddControllers;

use App\Entity\HoraireRestaurant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddHoraireReactController extends AbstractController
{
    #[Route('/addHoraire', name: 'addHoraire')]
    public function index(Request $test, EntityManagerInterface $em)
    {
        if ($test->headers->get('content-type') === "application/json") {
            $testform = json_decode($test->getContent(), true);
            $horaire = new HoraireRestaurant();
            $horaire->setJour($testform['Jour']);
            $horaire->setOuvert($testform['Ouvert']);
            if($testform['OpenMidi']){
              $horaire->setOpenMidi(\DateTimeImmutable::createFromFormat('H:i',$testform['OuvertureMidi']));
              $horaire->setCloseMidi(\DateTimeImmutable::createFromFormat('H:i',$testform['FermetureMidi']));
            }
            if($testform['OpenSoir']){
              $horaire->setOpenSoir(\DateTimeImmutable::createFromFormat('H:i',$testform['OuvertureSoir']));
              $horaire->setCloseSoir(\DateTimeImmutable::createFromFormat('H:i',$testform['FermetureSoir']));
            }
            $em->persist($horaire);
            $em->flush();
            return new JsonResponse(['Message' => 'L\'ajout de Horaire s\'est bien dérouler']);
        } else {
            return new JsonResponse(['Message' => 'PAs du bon type','Error' => 'Json only']);
        }
    }
}
