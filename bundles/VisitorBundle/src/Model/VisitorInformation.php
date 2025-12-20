<?php

namespace Nora\VisitorBundle\Model;

abstract class VisitorInformation
{

    public int $id;
    public string $ip;
    public string $userAgent;
    public \DateTimeImmutable $createdAt;
}
