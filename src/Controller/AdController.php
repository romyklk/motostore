<?php

namespace App\Controller;

use FontLib\EOT\File;
use Twig\Environment;
use App\Form\DevisType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Service\PdfGenerator;
use App\Service\MailerService;
use App\Repository\AdRepository;
use App\Repository\MarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\GeneralSettingsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Cache\ItemInterface;

class AdController extends AbstractController
{



    #[Route('/ad', name: 'app_ad')]
    public function index(Request $request, AdRepository $adRepository, MarkRepository $markRepository, PaginatorInterface $paginatorInterface, Environment $twig): Response
    {
        $siteSettings = $twig->getGlobals()['siteSettings'];


        $marks = $markRepository->findAll();

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ads = $adRepository->findBySearch($searchData);
        }

        // Mettre en cache les annonces
        $cache = new FilesystemAdapter();
        $ads = $cache->get('ads', function (ItemInterface $item) use ($adRepository) {
            $item->expiresAfter(3600); // Durée de vie du cache : 1 heure
            return $adRepository->findBy([
                'active' => true
            ], [
                'createdAt' => 'DESC'
            ]);
        });

        $ads = $paginatorInterface->paginate(
            $ads,
            $request->query->getInt('page', 1),
            12
        );




        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
            'marks' => $marks,
            'siteSettings' => $siteSettings,
            'form' => $form->createView()
        ]);
    }

    #[Route('/ad/{slug}', name: 'app_ad_show', methods: ['GET'])]
    public function show(string $slug, AdRepository $adRepository, Environment $twig): Response
    {
        $siteSettings = $twig->getGlobals()['siteSettings'];

        $ad = $adRepository->findOneBy(
            ['slug' => $slug, 'active' => true]
        );

        if (!$ad) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas');
        }

        $mark = $ad->getMark();
        $ads = $adRepository->findBy(['mark' => $mark]);
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
            'ads' => $ads,
            'siteSettings' => $siteSettings
        ]);
    }

    #[Route('/ad/{slug}/devis', name: 'app_ad_devis')]
    public function devis(string $slug, Request $request, EntityManagerInterface $em, AdRepository $adRepository, MailerService $mailerService, PdfGenerator $pdfGenerator, Environment $twig): Response
    {

        $siteSettings = $twig->getGlobals()['siteSettings'];

        $ad = $adRepository->findOneBy(
            ['slug' => $slug, 'active' => true]
        );


        if (!$ad) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas');
        }

        $form = $this->createForm(DevisType::class);
        $form->handleRequest($request);

        $countryCode = [
            'France ' => '33',
            'Allemagne' => '49',
            'Espagne' => '34',
            'Italie' => '39',
            'Portugal' => '351',
            'Pays-Bas' => '31',
            'Belgique' => '32',
            'Grèce' => '30',
            'Autriche' => '43',
            'Finlande' => '358',
            'Irlande' => '353',
            'Luxembourg' => '352',
            'Malte' => '356',
            'Slovénie' => '386',
            'Chypre' => '357'
        ];

        if ($form->isSubmitted() && $form->isValid()) {

            $devis = $form->getData();

            if (!empty($devis->getAddress())) {
                return $this->redirectToRoute('app_ad');
            }
            $devis->setAd($ad);
            $em->persist($devis);
            $em->flush();

            flash()
                ->options([
                    'timeout' => 5000,
                ])
                ->addSuccess(
                    'Votre demande de devis pour l\'annonce ' . $ad->getTitle() . ' a bien été envoyée.Un conseiller vous contactera dans les plus brefs délais.',
                    'Félicitations'
                );




            
            // Envoi de l'email de confirmation
            $fullName = $devis->getFirstName() . ' ' . $devis->getLastName();
            $mailerService->sendEstimate($devis->getEmail(), $ad, $fullName);

            // Envoi de l'email à l'administrateur
            $formData = [
                'message' => $devis->getMessage(),
                'phone' => $devis->getTel(),
                'email' => $devis->getEmail(),
                'name' => $fullName,
            ];

            $mailerService->sendEstimateToAdmin($devis->getEmail(), $fullName, $devis->getEmail(), $formData, $ad);
            

            // Generate PDF


            $imagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/ads/' . $ad->getMainPicture();
            $imageContent = base64_encode(file_get_contents($imagePath));

            $pdfContent = $pdfGenerator->generatePdfFromTemplate('pdf/invoice_pdf.html.twig', [
                'ad' => $ad,
                'fullName' => $fullName,
                'email' => $devis->getEmail(),
                'phone' => $devis->getTel(),
                'imageContent' => $imageContent,
            ]);

            $pdfFileName = 'devis_' . $fullName . '_' . uniqid() . '.pdf';
            $pdfPath = $this->getParameter('kernel.project_dir') . '/public/uploads/devispdfs/' . $pdfFileName;
            file_put_contents($pdfPath, $pdfContent);

            return $this->redirectToRoute('app_ad_show', ['slug' => $ad->getSlug()]);
        }

        return $this->render('ad/devis.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
            'countryCode' => $countryCode,
            'siteSettings' => $siteSettings
        ]);
    }
}
