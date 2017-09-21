<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ContainerInterface;
use Interop\Container\ServiceProvider;
use Interop\Container\ServiceProviderInterface;

class SimplexServiceProvider implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array(
            'param' => array(SimplexServiceProvider::class, 'getParam'),
            'service' => function() {
                return new Service();
            },
        );
    }

    public function getExtensions()
    {
        return array(
            'previous' => array(SimplexServiceProvider::class, 'getPrevious'),
        );
    }

    public static function getParam()
    {
        return 'value';
    }

    public static function getPrevious(ContainerInterface $container, $previous = null)
    {
        return $previous.$previous;
    }
}
