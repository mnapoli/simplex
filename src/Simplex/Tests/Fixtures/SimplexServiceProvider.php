<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ContainerInterface;
use Interop\Container\ServiceProvider;

class SimplexServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return array(
            'param' => array(SimplexServiceProvider::class, 'getParam'),
            'service' => function() {
                return new Service();
            },
            'previous' => array(SimplexServiceProvider::class, 'getPrevious'),
        );
    }

    public static function getParam()
    {
        return 'value';
    }

    public static function getPrevious(ContainerInterface $container, callable $getPrevious = null)
    {
        return $getPrevious;
    }
}
