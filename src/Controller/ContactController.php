<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="app_contact")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hostname = $request->getSchemeAndHttpHost();
            $nom = $form->get('name')->getData();
            $firstName = $form->get('firstName')->getData();
            $business = $form->get('business')->getData();
            $email = $form->get('email')->getData();
            $email2 = $form->get('email')->getData();
            $telephone = $form->get('telephone')->getData();
            $sujet = $form->get('sujet')->getData();
            $content = $form->get('content')->getData();

            $email = (new TemplatedEmail())
                ->from($email)
                ->to(new Address('vivien.joly@hotmail.fr', 'Vivien'))
                ->subject($sujet)
                ->context([
                    'firstName' => $firstName,
                    'name' => $nom,
                    'business' => $business,
                    'mail' => $email,
                    'telephone' => $telephone,
                    'sujet' => $sujet,
                    'contenu' => $content
                ])
                ->htmlTemplate('formulaire/contact.html.twig');
            $mailer->send($email);

            $email2 = (new TemplatedEmail())
                ->from(new Address('vivien.joly@hotmail.fr', 'Vivien'))
                ->to($email2)
                ->subject('Réponse à votre mail')
                ->context([
                    'firstName' => $firstName,
                    'name' => $nom,
                    'business' => $business,
                    'hostname' => $hostname
                ])
                ->htmlTemplate('formulaire/reponseContact.html.twig');
            $mailer->send($email2);

            $message = $translator->trans('Votre message est envoyée !');
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
