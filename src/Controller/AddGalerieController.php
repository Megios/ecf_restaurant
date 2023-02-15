<?php
namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieForm;
use App\Entity\HoraireRestaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AddGalerieController extends AbstractController
{
    #[Route('/admin/newImage', name: 'app_galerie_new')]
    public function new(Request $request, SluggerInterface $slugger,EntityManagerInterface $em)
    {
      $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir(),'id' =>$jour->getId()];
        }
        $image = new Galerie;
        $form = $this->createForm(GalerieForm::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFilename')->getData();
            $imageFormat = $form->get('format')->getData();
            $imageOrdre= $form->get('ordre')->getData();

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $image->setImageFilename($newFilename);
                $image->setFormat($imageFormat);
                $image->setOrdre(intval($imageOrdre));
            }

            $em->persist($image);
            $em->flush();


            return $this->redirectToRoute('app_admin_page');
        }

        return $this->render('admin_page/newImage.html.twig', [
            'form' => $form,
            'semaine' => $horaireSemaine,
        ]);
    }
}
?>