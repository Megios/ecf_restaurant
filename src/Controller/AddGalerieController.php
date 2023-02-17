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
    #[Route('/admin/structure', name: 'app_structure')]
    public function index(Request $request,EntityManagerInterface $em)
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir(),'id' =>$jour->getId()];
        }
        $galeries = $em->getRepository(Galerie::class)->findBy(array(),array('ordre'=>'ASC'));
        return $this->render('admin_page/structure.html.twig', [
            'semaine' => $horaireSemaine,
            'galeries' => $galeries
        ]);

}


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
            $imageTitre= $form->get('titre')->getData();

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
                $image->setTitre($imageTitre);
            }

            $em->persist($image);
            $em->flush();


            return $this->redirectToRoute('app_structure');
        }

        return $this->render('admin_page/newImage.html.twig', [
            'form' => $form,
            'semaine' => $horaireSemaine,
        ]);
    }
    #[Route('/admin/removeImage/{id}', name: 'app_galerie_remove')]
    public function remove(Request $request, EntityManagerInterface $em,Galerie $image)
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir(),'id' =>$jour->getId()];
        }
        $id = $request->get('id');
        $image= $em->getRepository(Galerie::class)->findoneBy(array('uuid'=>$id));
        if ($image){
            $nomImage= $this->getParameter("images_directory").'/'.$image->getimageFilename();
            if(file_exists($nomImage)){
                unlink($nomImage);
            }
        }
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('app_structure');
}
}
?>