<?php

declare(strict_types=1);

namespace App\Controller;

use Nora\EntitiesVisitorBundle\VisitorCounter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(VisitorCounter $counter): Response
    {
        dd($counter->incrementCounter(1));
        return $this->render('home/index.html.twig');
    }
}
