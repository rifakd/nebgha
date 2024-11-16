<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home1', name: 'app_home1')]
    public function index1(): Response
    {
        return $this->render('front/404.html.twig');
    }
    #[Route('/home2', name: 'app_home2')]
    public function index2(): Response
    {
        return $this->render('front/about.html.twig');
    }
    #[Route('/home3', name: 'app_home3')]
    public function index3(): Response
    {
        return $this->render('front/contact.html.twig');
    }
    #[Route('/home4', name: 'app_home4')]
    public function index4(): Response
    {
        return $this->render('front/courses.html.twig');
    }
    #[Route('/home5', name: 'app_home5')]
    public function index5(): Response
    {
        return $this->render('front/index.html.twig');
    }
    #[Route('/home6', name: 'app_home6')]
    public function index6(): Response
    {
        return $this->render('front/team.html.twig');
    }
    #[Route('/home7', name: 'app_home7')]
    public function index7(): Response
    {
        return $this->render('front/testimonial.html.twig');
    }
    #[Route('/home8', name: 'app_home8')]
    public function index8(): Response
    {
        return $this->render('back/billing.html.twig');
    }

    #[Route('/home9', name: 'app_home9')]
    public function index9(): Response
    {
        return $this->render('back/dashboard.html.twig');
    }
    #[Route('/home10', name: 'app_home10')]
    public function index10(): Response
    {
        return $this->render('back/profile.html.twig');
    }
    #[Route('/home11', name: 'app_home11')]
    public function index11(): Response
    {
        return $this->render('back/rtl.html.twig');
    }
    #[Route('/home12', name: 'app_home12')]
    public function index12(): Response
    {
        return $this->render('back/sign-in.html.twig');
    }
    #[Route('/home13', name: 'app_home13')]
    public function index13(): Response
    {
        return $this->render('back/sign-up.html.twig');
    }
    #[Route('/home14', name: 'app_home14')]
    public function index14(): Response
    {
        return $this->render('back/tables.html.twig');
    }
    #[Route('/home15', name: 'app_home15')]
    public function index15(): Response
    {
        return $this->render('back/virtual-reality.html.twig');
    }
}
