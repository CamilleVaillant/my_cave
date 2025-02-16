<?php

namespace App\Controller\Admin;

use App\Entity\User;
// use Symfony\Component\Routing\Route;


use App\Entity\Wine;
use App\Entity\Cepage;
use App\Entity\Region;
use App\Entity\Country;
use App\Controller\Admin\CepageCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;




class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My Cave');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Quitter l\'admin', 'fa-solid fa-sign-out-alt', 'app_home');
        yield MenuItem::linkToCrud('Les Vins', 'fa-solid fa-wine-bottle', Wine::class);
        yield MenuItem::linkToCrud('les Cépages','fa-solid fa-leaf', Cepage::class);
        yield MenuItem::linkToCrud('les Pays','fa-solid fa-earth-europe', Country::class);
        yield MenuItem::linkToCrud('les Regions','fa-regular fa-map', Region::class);
        yield MenuItem::linkToCrud('les Utilisateurs','fa-regular fa-user', User::class);
    }
}
