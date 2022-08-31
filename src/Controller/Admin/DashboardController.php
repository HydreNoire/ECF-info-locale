<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        $url = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($url->setController(ArticleCrudController::class)->generateUrl());  
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Info Locale');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', "fa-solid fa-arrow-left", "app_home");
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Infos');
        yield MenuItem::subMenu('Article', 'fa fa-file-text')->setSubItems([
                MenuItem::linkToCrud('All Posts', 'fa fa-file-text', Article::class)->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Add Post', 'fa fa-file-text', Article::class)->setAction(Crud::PAGE_NEW)
            ]);
    }
}
