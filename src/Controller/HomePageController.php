<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Entity\HoraireRestaurant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(EntityManagerInterface $em): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }
        $galeries= $em->getRepository(Galerie::class) ->findBy(array(),array('ordre'=>'asc'));
        if (!$galeries){
            $photo = [];
            for ($i=0; $i < 4; $i++) { 
                $tempPhoto = [
                    'format' => 'paysage',
                    'source' =>'./image/testpaysage.jpg',
                    'title' => 'Test image'
        
                ];
                array_push($photo,$tempPhoto);
            }
        }else{
            $photo=[];
            foreach ($galeries as $image) {
                $tempPhoto = [
                    'format' => $image->getFormat(),
                    'source' => '/image'.'/'.$image->getimageFilename(),
                    'title' => $image->getTitre(),
                ];
                array_push($photo,$tempPhoto);
            }

        }

        
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'semaine' => $horaireSemaine,
            'photo' => $photo
        ]);
    }
}
