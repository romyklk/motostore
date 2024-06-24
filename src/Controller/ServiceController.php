<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\CgvRepository;
use App\Repository\RefundRepository;
use App\Repository\PrivacyRepository;
use App\Repository\DeliveryRepository;
use App\Repository\MentionsRepository;
use App\Repository\FinancementRepository;
use App\Repository\GeneralSettingsRepository;
use App\Repository\ReviewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{


    #[Route('/service', name: 'app_service')]
    public function index(Environment $twig): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
            'siteSettings' => $twig->getGlobals()['siteSettings']
        ]);
    }

    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function mentionsLegales(MentionsRepository $mentionsRepository, Environment $twig): Response
    {
        $mentions = $mentionsRepository->find(1);
        return $this->render('service/mentions-legales.html.twig', [
            'page' => $mentions,
            'siteSettings' => $twig->getGlobals()['siteSettings']
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'app_politique_de_confidentialite')]
    public function politiqueDeConfidentialite(PrivacyRepository $privacyRepository, Environment $twig): Response
    {
        $privacy = $privacyRepository->find(1);
        return $this->render('service/politique-de-confidentialite.html.twig', [
            'page' => $privacy,
            'siteSettings' => $twig->getGlobals()['siteSettings']
        ]);
    }

    #[Route('/remboursement', name: 'app_remboursement')]
    public function remboursement(RefundRepository $refundRepository, Environment $twig): Response
    {
        $refund = $refundRepository->find(1);
        return $this->render('service/remboursement.html.twig', [
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'page' => $refund
        ]);
    }

    #[Route('/livraison', name: 'app_livraison')]
    public function livraison(DeliveryRepository $deliveryRepository, Environment $twig): Response
    {
        $delivery = $deliveryRepository->find(1);
        return $this->render('service/livraison.html.twig', [
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'page' => $delivery
        ]);
    }

    #[Route('/cgv', name: 'app_cgv')]
    public function cgv(CgvRepository $cgvRepository, Environment $twig): Response
    {
        $cgv = $cgvRepository->find(1);
        return $this->render('service/cgv.html.twig', [
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'page' => $cgv
        ]);
    }

    #[Route('/financement', name: 'app_financement')]
    public function financement(FinancementRepository $financementRepository, Environment $twig): Response
    {
        $financement = $financementRepository->find(1);
        return $this->render('service/financement.html.twig', [
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'page' => $financement
        ]);
    }

    #[Route('/testimonials', name: 'app_testimonials')]
    public function testimonials(ReviewsRepository $reviewsRepository, Environment $twig): Response
    {
        $reviews = $reviewsRepository->findAll(
            ['createdAt' => 'DESC'],
        );
        return $this->render('service/testimonials.html.twig', [
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'reviews' => $reviews
        ]);
    }
}
