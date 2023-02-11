<?php

namespace App\Controller\AddControllers;

use App\Entity\Carte;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddCarteReactController extends AbstractController
{
    #[Route('/addCarte', name: 'addCarte')]
    public function index(Request $test, EntityManagerInterface $em)
    {
        if ($test->headers->get('content-type') === "application/json") {
            $testform = json_decode($test->getContent(), true);
            $carte = new Carte();
            $carte->setNom($testform['Nom']);
            $ind=intval($testform['Ordre']);
            while ($em->getRepository(Carte::class)->findOneby(array('ordre' => $ind))) {
                $em->getRepository(Carte::class)->findOneby(array('ordre' => $ind ))->setOrdre($ind+1);
                $ind++;
            }
            $carte->setOrdre(intval($testform['Ordre']));
            $em->persist($carte);
            $em->flush();
            return new JsonResponse(['Message' => 'L\'ajout de carte s\'est bien dérouler']);
        } else {
            return new JsonResponse(['Message' => 'PAs du bon type','Error' => 'Json only']);
        }
    }
}
