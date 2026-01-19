<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SiteMapController extends AbstractController
{
    #[Route("sitemap.xml", name: 'sitemap', format: 'xml')]
    public function index(): Response
    {
        $urls = [];
        $urls[] = [
            'loc' => $this->generateUrl('app_home', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ];

        $response = new Response(
            $this->renderView('sitemap/sitemap.xml.twig', [
                'urls' => $urls,
            ]),
            Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
