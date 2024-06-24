<?php

namespace App\Controller;

use Twig\Environment;
use App\Form\ContactType;
use App\Service\MailerService;
use App\Repository\GeneralSettingsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{


    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerService $mailerService, Environment $twig): Response
    {
        $siteSettings = $twig->getGlobals()['siteSettings'];

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            if (empty($contactFormData['address']) && empty($contactFormData['city']) && empty($contactFormData['zip']) && empty($contactFormData['country'])) {
                $mailerService->sendMailToAdmin(
                    $contactFormData['email'],
                    $contactFormData['name'],
                    $contactFormData['email'],
                    [
                        'message' => $contactFormData['message'],
                        'phone' => $contactFormData['phone'],
                        'name' => $contactFormData['name'],
                    ]
                );
                //Vider le formulaire
                $form = $this->createForm(ContactType::class);

                flash()
                    ->options([
                        'timeout' => 5000,
                    ])
                    ->addSuccess(
                        'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.',
                        'Félicitations'
                    );
            }else{
               return $this->redirectToRoute('app_home');
            }
        }


        return $this->render('contact/index.html.twig', [
            'siteSettings' => $siteSettings,
            'form' => $form->createView(),
        ]);
    }
}
