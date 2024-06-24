<?php

namespace App\Controller;

use Twig\Environment;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\AdRepository;
use App\Repository\MarkRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\GeneralSettingsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarkController extends AbstractController
{


    #[Route('/mark/{slug}', name: 'app_mark_show')]
    public function index(string $slug,Request $request, AdRepository $adRepository,MarkRepository $markRepository,PaginatorInterface $paginatorInterface, Environment $twig): Response
    {
        // Convertir le nom de marque en slug en minuscules
        $search = mb_strtolower($slug);
        

        $markSlug = $markRepository->findOneBy(['slug' => $search]);
        $ads = $adRepository->findBy([
            'mark' => $markSlug,
            'active' => true
        ], [
            'createdAt' => 'DESC'
        ]);

        if(!$markSlug){
            throw $this->createNotFoundException('La marque demandée n\'existe pas');
        }

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ads = $adRepository->findBySearch($searchData);
        }

        $ads = $paginatorInterface->paginate(
            $ads,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'marks' => $markRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/filter/{sort}', name: 'app_mark_filter')]
    public function filter(string $sort,Request $request, AdRepository $adRepository,MarkRepository $markRepository, PaginatorInterface $paginatorInterface, Environment $twig): Response
    {
        if($sort=='asc'){
            $ads = $adRepository->findBy([
                'active' => true
            ], [
                'price' => 'ASC'
            ]);}
            else if($sort=='desc'){
                $ads = $adRepository->findBy([
                    'active' => true
                ], [
                    'price' => 'DESC'
                ]);
            }else if($sort== 'desc_date'){
                $ads = $adRepository->findBy([
                    'active' => true
                ], [
                    'createdAt' => 'DESC'
                ]);
            }else if($sort== 'asc_date'){
                $ads = $adRepository->findBy([
                    'active' => true
                ], [
                    'createdAt' => 'ASC'
                ]);
            }else{
                $ads = $adRepository->findBy([
                    'active' => true
                ], [
                    'createdAt' => 'DESC'
                ]);
            }
          
    

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ads = $adRepository->findBySearch($searchData);
        }

        $ads = $paginatorInterface->paginate(
            $ads,
            $request->query->getInt('page', 1),
            12
        );

        if(!$ads){
            throw $this->createNotFoundException('Aucune annonce pour cette marque');
        }

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
            'siteSettings' => $twig->getGlobals()['siteSettings'],
            'marks' => $markRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

}
