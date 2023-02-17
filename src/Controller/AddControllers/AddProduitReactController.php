<?php

namespace App\Controller\AddControllers;

use App\Entity\Carte;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddProduitReactController extends AbstractController
{
    #[Route('/addProduit', name: 'addProduit')]
    public function index(Request $test, EntityManagerInterface $em)
    {
        if ($test->headers->get('content-type') === "application/json") {
            $testform = json_decode($test->getContent(), true);
            $produit = new Produit();
            $produit->setNom($testform['Nom']);
            $produit->setPrix(intval($testform['Prix']));
            $ind=intval($testform['Ordre']);
            $sousCat = $em->getRepository(SousCategorie::class)->findOneby(array('nom' => $testform['SousCategorie']));
            while ($em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind))) {
                $em->getRepository(Produit::class)->findOneby(array('sousCategorie' => $sousCat,'ordre' => $ind ))->setOrdre($ind+1);
                $ind++;
            }
            $produit->setOrdre(intval($testform['Ordre']));
            $produit->setSousCategorie($sousCat);
            $em->persist($produit);
            $em->flush();
            return new JsonResponse(['Message' => 'L\'ajout de la catégorie s\'est bien dérouler']);
        } else {
            return new JsonResponse(['Message' => 'PAs du bon type','Error' => 'Json only']);
        }
    }
}