<?php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Nora\EntitiesVisitorBundle\VisitorCounter;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('nora.visitor_counter', VisitorCounter::class)
        ->alias(VisitorCounter::class, 'nora.visitor_counter')
    ;
};
