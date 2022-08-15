<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Contact;
use App\Form\CandidatureType;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    /**
     * @Route("/candidature", name="app_candidature")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $candidature = new Candidature();

        $form = $this->createForm(CandidatureType::class, $candidature);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $someNewFilename = 'CV'.'-'.uniqid();
            $directory = 'image';

            $nom = $form->get('name')->getData();
            $firstName = $form->get('firstName')->getData();
            $experience = $form->get('experience')->getData();
            $email = $form->get('email')->getData();
            $email2 = $form->get('email')->getData();
            $telephone = $form->get('telephone')->getData();
            $lm = $form->get('lm')->getData();
            $cv = $form->get('cv')->getData();
            $extension = $cv->guessExtension();
            $cv->move($directory, $someNewFilename.'.'.$extension);

            $email = (new TemplatedEmail())
                ->from($email)
                ->to(new Address('vivien.joly@hotmail.fr', 'Vivien'))
                ->subject('Candidature')
                ->context([
                    'firstName' => $firstName,
                    'name' => $nom,
                    'experience' => $experience,
                    'mail' => $email,
                    'telephone' => $telephone,
                    'lm' => $lm,
                ])
                ->attachFromPath($directory.'/'.$someNewFilename.'.'.$extension)
                ->htmlTemplate('formulaire/candidature.html.twig');
            $mailer->send($email);

            unlink($directory.'/'.$someNewFilename.'.'.$extension);

            $email2 = (new TemplatedEmail())
                ->from(new Address('vivien.joly@hotmail.fr', 'Vivien'))
                ->to($email2)
                ->subject('Réponse à votre candidature')
                ->context([
                    'firstName' => $firstName,
                    'name' => $nom,
                ])
                ->htmlTemplate('formulaire/reponseCandidature.html.twig');
            $mailer->send($email2);

            $this->addFlash('success', 'Votre candidature est envoyée !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('candidature/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
