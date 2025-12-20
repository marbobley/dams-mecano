<?php

declare(strict_types=1);

namespace App\Controller;

use Nora\VisitorBundle\src\NoraVisitorBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        $bundle = new NoraVisitorBundle();
        dd($bundle->helloWorld());
        return $this->render('home/index.html.twig');
    }
}
