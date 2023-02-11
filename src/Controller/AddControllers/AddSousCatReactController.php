<?php

namespace App\Controller\AddControllers;

use App\Entity\Carte;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddSousCatReactController extends AbstractController
{
    #[Route('/addSousCat', name: 'addSousCat')]
    public function index(Request $test, EntityManagerInterface $em)
    {
        if ($test->headers->get('content-type') === "application/json") {
            $testform = json_decode($test->getContent(), true);
            $sousCat = new SousCategorie();
            $sousCat->setNom($testform['Nom']);
            $ind=intval($testform['Ordre']);
            $carte = $em->getRepository(Carte::class)->findOneby(array('nom' => $testform['Carte']));
            while ($em->getRepository(SousCategorie::class)->findOneby(array('carte' => $carte,'ordre' => $ind))) {
                $em->getRepository(sousCategorie::class)->findOneby(array('carte' => $carte,'ordre' => $ind ))->setOrdre($ind+1);
                $ind++;
            }
            $sousCat->setOrdre(intval($testform['Ordre']));
            $sousCat->setCarte($carte);
            $em->persist($sousCat);
            $em->flush();
            return new JsonResponse(['Message' => 'L\'ajout de la catégorie s\'est bien dérouler']);
        } else {
            return new JsonResponse(['Message' => 'PAs du bon type','Error' => 'Json only']);
        }
    }
}