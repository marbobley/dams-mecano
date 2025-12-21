<?php

namespace Nora\EntitiesVisitorBundle\Model;

abstract class VisitorInformation{
    public string $ip;
    public string $userAgent;
    public \DateTimeImmutable $visitedAt;


}
