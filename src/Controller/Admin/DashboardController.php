<?php

// src/Controller/Admin/DashboardController.php
namespace App\Controller\Admin;

use App\Entity\Offre;
use App\Controller\Admin\OffreCrudController;
use App\Entity\Postulation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;

use App\Repository\PostulationRepository;
use App\Repository\UserRepository;
use App\Repository\OffreRepository;



class DashboardController extends AbstractDashboardController
{
    private OffreRepository $offreRepository;
    private PostulationRepository $postulationRepository;
    private UserRepository $userRepository;

    public function __construct(
        OffreRepository $offreRepository,
        PostulationRepository $postulationRepository,
        UserRepository $userRepository
    ) {
        $this->offreRepository = $offreRepository;
        $this->postulationRepository = $postulationRepository;
        $this->userRepository = $userRepository;
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        $nbOffres = $this->offreRepository->count([]);
        $nbPostulations = $this->postulationRepository->count([]);
        $nbUsers = $this->userRepository->count([]);
        $postulations = $this->postulationRepository->findAll();
        

        return $this->render('admin/dashboard.html.twig', [
            'nb_offres' => $nbOffres,
            'nb_postulations' => $nbPostulations,
            'nb_users' => $nbUsers,
            'postulations' => $postulations,

            

        ]);
    }
    


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Offres', 'fas fa-briefcase', Offre::class);
        yield MenuItem::linkToCrud('Postulations', 'fas fa-file-alt', Postulation::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user-alt', User::class);


    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<h2>admin dashboard</h2>');
    }
}

