<?php

namespace App\EventListener;

use App\Entity\VisitorInformation;
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
        $this->logger->info('Visitor Information');
        $clientIP = $event->getRequest()->getClientIp()?? 'Unknown';
        $userAgent = $event->getRequest()->headers->get('User-Agent') ?? 'Unknown';

        $visitor = new VisitorInformation();
        $visitor->ip = $clientIP;
        $visitor->userAgent = $userAgent;
        $visitor->visitedAt = new \DateTimeImmutable();
        $this->manager->persist($visitor);
        $this->manager->flush();
    }
}
