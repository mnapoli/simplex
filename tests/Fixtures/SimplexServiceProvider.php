<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class SimplexServiceProvider implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array(
            'param' => array(__CLASS__, 'getParam'),
            'service' => function() {
                return new Service();
            },
        );
    }

    public function getExtensions()
    {
        return array(
            'previous' => array(__CLASS__, 'getPrevious'),
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
