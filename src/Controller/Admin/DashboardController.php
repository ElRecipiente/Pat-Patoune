<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\User;
use App\Entity\Vax;
use App\Entity\Visit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AnimalCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PatPatoune');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Animals', 'fa fa-home', Animal::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-home', User::class);
        yield MenuItem::linkToCrud('Vaccinations', 'fa fa-home', Vax::class);
        yield MenuItem::linkToCrud('Visits', 'fa fa-home', Visit::class);
    }
}
