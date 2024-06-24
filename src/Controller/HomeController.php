<?php

namespace App\Controller;



use Twig\Environment;
use App\Model\SearchData;
use App\Repository\AdRepository;
use App\Repository\MarkRepository;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\ItemInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(AdRepository $adRepository, MarkRepository $markRepository, Environment $twig): Response
    {
        $siteSettings = $twig->getGlobals()['siteSettings'];

        /*  $ads = $adRepository->findBy([
            'active' => true
        ], [
            'createdAt' => 'DESC'
        ], 6); */

        $cache = new FilesystemAdapter();

        $ads = $cache->get('ads', function (ItemInterface $item) use ($adRepository) {
                $item->expiresAfter(3600); 
                return $adRepository->findBy(['active' => true], ['createdAt' => 'DESC'], 6);
            });


        $marks = $markRepository->findAll();

        return $this->render('home/index.html.twig', [
            'ads' => $ads,
            'marks' => $marks,
            'siteSettings' => $siteSettings
        ]);
    }

    /* 

    #[Route('/', name: 'app_home')]
    public function index(
        AdRepository $adRepository,
        MarkRepository $markRepository,
        Environment $twig,
    ): Response {

        $siteSettings = $twig->getGlobals()['siteSettings'];

        $ads = $this->cacheAds($adRepository);
        $marks = $this->cacheMarks($markRepository);

        return $this->render('home/index.html.twig', [
            'ads' => $ads,
            'marks' => $marks,
            'siteSettings' => $siteSettings,
        ]);
    }


    private function cacheAds(AdRepository $adRepository): array
    {
        $cache = new FilesystemAdapter();
        return $cache->get('home_ads', function (CacheItem $item) use ($adRepository) {
            $item->expiresAfter(60);
            return $adRepository->findBy([
                'active' => true
            ], [
                'createdAt' => 'DESC'
            ], 6);
        });
    }


    private function cacheMarks(MarkRepository $markRepository): array
    {
        $cache = new FilesystemAdapter();
        return $cache->get('home_marks', function (CacheItem $item) use ($markRepository) {
            $item->expiresAfter(60);
            return $markRepository->findAll();
        });
    } */
}
