<?php

namespace App\Controller;

use App\Entity\Faq;
use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(FaqRepository $faqRepository): Response
    {
        $faqs = $faqRepository->findAll(
            ['createdAt' => 'DESC']
        );
        return $this->render('faq/index.html.twig', [
            'faqs' => $faqs,
        ]);
    }
}
