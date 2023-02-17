<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EnvoyeurEmail;
use App\Form\ResetPasswordForm;
use App\Entity\HoraireRestaurant;
use App\Form\ResetPasswordWithToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,EntityManagerInterface $em): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }
        if ($this->getUser()) {
            return $this->redirectToRoute('target_path');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'semaine' => $horaireSemaine]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/oubliePass', name: 'app_forgot_password')]
    public function oubliePassword(Request $request,EntityManagerInterface $em, TokenGeneratorInterface $tokenGeneratorInterface): Response
    {
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }
        $form= $this->createForm(ResetPasswordForm::class);
        $error= null;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $em->getRepository(User::class)->findOneByEmail($form->get('email')->getData());
            if($user){
                $token = $tokenGeneratorInterface->generateToken();
                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();

                $url= $this->generateUrl('app_reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL );
                $message = "Votre demande de reinitialisation en été prit en compte \r\n, cliqué sur ce lien :". $url;
                $sendmail = new EnvoyeurEmail();
                $sendmail->sendMail($user->getEmail(),"Reinitialisation de mot de passe", $message);
                $error= 'Vous trouverez le lien dans votre adresse mail';

            }
            else{
                $error= 'Une erreur est survenu';
            }
        };

        return $this->render('security/reset_password_request.html.twig',['semaine' => $horaireSemaine, 'requestPassForm'=> $form->createView(),'error' => $error]);
    }

    #[Route('oubliePass/{token}', name:'app_reset_pass')]
    public function resetPass(string $token, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher):Response
    {
        $error=null;
        $semaine = $em->getRepository(HoraireRestaurant::class)->findAll();
        $horaireSemaine = [];
        foreach ($semaine as $jour) {
            $horaireSemaine[$jour->getJour()] = ['open' => $jour->isOuvert(), 'open_midi' => $jour->getOpenMidi(), 'close_midi' => $jour->getCloseMidi(), 'open_soir' => $jour->getOpenSoir(), 'close_soir' => $jour->getCloseSoir()];
        }
        $user= $em->getRepository(User::class)->findOneByResetToken($token);
        if(!$user){
            return $this->redirectToRoute('app_login');
        }
        $form =$this->createForm(ResetPasswordWithToken::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user->setResetToken(null);
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $user->setPassword($hashedPassword);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        else{
            if($form->isSubmitted() && !$form->isValid())
            $error= 'une erreur est survenu';
        }
        return $this->render('security/reset_password_with_token.html.twig', ['semaine' => $horaireSemaine,'passForm' => $form->createView(),'error' => $error]);
    }
}
