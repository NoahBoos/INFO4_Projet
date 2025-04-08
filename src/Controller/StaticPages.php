<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPages extends AbstractController {
    #[Route('/', name: 'index')]
    public function index(): Response {
        return $this->render('base.html.twig', [
            'title' => 'Page d\'accueil',
        ]);
    }

    #[Route('/workInProgress', name: 'work_in_progress', methods: ['GET'])]
    public function workInProgress(): Response {
        return $this->render('work_in_progress.html.twig', [
           'title' => 'Page en construction...'
        ]);
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function adminDashboard(): Response {
        return $this->render('admin/admin_dashboard.html.twig', [
            'title' => 'Panneau d\'administration'
        ]);
    }

    #[Route('/professional/dashboard', name: 'professional_dashboard')]
    public function professionalDashboard(): Response {
        return $this->render('professional/professional_dashboard.html.twig', [
            'title' => 'Panneau professionnel'
        ]);
    }
}