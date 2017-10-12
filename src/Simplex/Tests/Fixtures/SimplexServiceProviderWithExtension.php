<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ContainerInterface;
use Interop\Container\ServiceProvider;
use Interop\Container\ServiceProviderInterface;

class SimplexServiceProviderWithExtension implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array();
    }

    public function getExtensions()
    {
        return array(
            'test' => function ($container, string $previous) {

                return $previous . 'def';

            },
        );
    }
}
