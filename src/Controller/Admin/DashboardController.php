<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use App\Entity\Cgv;
use App\Entity\Faq;
use App\Entity\Mark;
use App\Entity\Refund;
use App\Entity\Privacy;
use App\Entity\Reviews;
use App\Entity\Delivery;
use App\Entity\Mentions;
use App\Entity\Financement;
use App\Entity\GeneralSettings;
use App\Controller\Admin\AdCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(AdCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administation du site')
            ->renderContentMaximized()
            //->renderSidebarMinimized()
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Annonces', 'fa fa-motorcycle', Ad::class);
        yield MenuItem::linkToCrud('Marques', 'fa fa-tag', Mark::class);
        yield MenuItem::linkToCrud('Réglages', 'fa fa-cog', GeneralSettings::class);
        yield MenuItem::linkToCrud('Conditions générales de vente', 'fa fa-file', Cgv::class);
        yield MenuItem::linkToCrud('Les avis', 'fa fa-star', Reviews::class);
        yield MenuItem::linkToCrud('Livraison', 'fa fa-truck', Delivery::class);
        yield MenuItem::linkToCrud('FAQ', 'fa fa-question', Faq::class);
        yield MenuItem::linkToCrud('Financement', 'fa fa-credit-card', Financement::class);
        yield MenuItem::linkToCrud('Mentions légales', 'fa fa-file', Mentions::class);
        yield MenuItem::linkToCrud('Politique de confidentialité', 'fa fa-file', Privacy::class);
        yield MenuItem::linkToCrud('remboursement', 'fa fa-file', Refund::class);
        yield MenuItem::linkToUrl('Retour', 'fa fa-home', '/');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
