<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\VisitorInformation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(EntityManagerInterface $manager, Request $request,): Response
    {
        $clientIP = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');

        $visitor = new VisitorInformation();
        $visitor->ip = $clientIP;
        $visitor->userAgent = $userAgent;
        $visitor->visitedAt = new \DateTimeImmutable();
        $manager->persist($visitor);
        $manager->flush();

        return $this->render('home/index.html.twig');
    }
}
