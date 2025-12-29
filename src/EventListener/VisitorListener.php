<?php

namespace App\EventListener;

use App\Entity\VisitorInformation;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

final readonly class VisitorListener
{
    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $manager)
    {

    }
    #[AsEventListener]
    public function onTerminateEvent(TerminateEvent $event): void
    {
        $request = $event->getRequest();

        // Informations de base
        $clientIP = $request->getClientIp() ?? 'Unknown';
        $userAgent = $request->headers->get('User-Agent') ?? 'Unknown';

        // Identifier le contrôleur/action et la route qui ont servi la requête
        // Symfony renseigne ces informations dans les attributs de la Request
        $controller = $request->attributes->get('_controller') ?? 'Unknown';
        $route = $request->attributes->get('_route') ?? 'Unknown';
        $path = $request->getPathInfo();
        $method = $request->getMethod();

        // Log détaillé pour savoir quel contrôleur a déclenché l'action
        $this->logger->info('Visitor Information', [
            'ip' => $clientIP,
            'method' => $method,
            'path' => $path,
            'route' => $route,
            'controller' => $controller,
            'userAgent' => $userAgent,
        ]);

        $visitor = new VisitorInformation();
        $visitor->ip = $clientIP;
        $visitor->userAgent = $userAgent;
        $visitor->visitedAt = new DateTimeImmutable();
        $this->manager->persist($visitor);
        $this->manager->flush();
    }
}
