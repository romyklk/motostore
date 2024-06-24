<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\MarkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
     #[Route('/sitemap.xml', name: 'app_sitemap', defaults: ['_format' => 'xml'])]
    public function index(
        Request $request,
        AdRepository $adRepository,
        MarkRepository $markRepository
    ): Response {

        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];
        $urls[] = ['loc' => $this->generateUrl('app_home')];
        $urls[] = ['loc' => $this->generateUrl('app_ad')];
        $urls[] = ['loc' => $this->generateUrl('app_service')];
        $urls[] = ['loc' => $this->generateUrl('app_register')];
        $urls[] = ['loc' => $this->generateUrl('app_login')];
        $urls[] = ['loc' => $this->generateUrl('app_contact')];
        $urls[] = ['loc' => $this->generateUrl('app_mentions_legales')];
        $urls[] = ['loc' => $this->generateUrl('app_politique_de_confidentialite')];
        $urls[] = ['loc' => $this->generateUrl('app_remboursement')];
        $urls[] = ['loc' => $this->generateUrl('app_cgv')];
        $urls[] = ['loc' => $this->generateUrl('app_financement')];
        $urls[] = ['loc' => $this->generateUrl('app_testimonials')];
        $urls[] = ['loc' => $this->generateUrl('app_livraison')];

        foreach ($adRepository->findAll() as $ad) {
            $images = [
                'loc' => '/uploads/ads/' . $ad->getMainPicture(),
                'title' => $ad->getTitle(),
            ];



            $urls[] = [
                'loc' => $this->generateUrl('app_ad_show', ['slug' => $ad->getSlug()]),
                'images' => $images,
                'lastmod' => $ad->getCreatedAt()->format('Y-m-d'),
            ];

            $urls[] = [
                'loc' => $this->generateUrl('app_ad_devis', ['slug' => $ad->getSlug()]),
            ];

            foreach (['asc', 'desc', 'desc_date', 'asc_date'] as $sort) {
                $urls[] = [
                    'loc' => $this->generateUrl('app_mark_filter', ['sort' => $sort]),
                ];
            }
        }

        foreach ($markRepository->findAll() as $mark) {
            $urls[] = [
                'loc' => $this->generateUrl('app_mark_show', ['slug' => $mark->getSlug()]),
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname,
            ]),
            200
        );


        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    } 
}
