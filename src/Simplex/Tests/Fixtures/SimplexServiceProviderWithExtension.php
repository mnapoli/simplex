<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ContainerInterface;
use Interop\Container\ServiceProvider;
use Interop\Container\ServiceProviderInterface;

class SimplexServiceProviderWithExtension implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [];
    }

    public function getExtensions()
    {
        return [
            'test' => function ($container, string $previous) {

                return $previous . 'def';

            },
        ];
    }
}
