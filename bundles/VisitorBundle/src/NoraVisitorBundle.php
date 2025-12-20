<?php
namespace Nora\VisitorBundle\src;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class NoraVisitorBundle extends AbstractBundle
{
    public function helloWorld() : string{
        return "Hello World";
    }
}
