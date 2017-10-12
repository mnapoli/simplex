<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ContainerInterface;
use Interop\Container\ServiceProvider;
use Interop\Container\ServiceProviderInterface;

class SimplexServiceProviderWithFactory implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'test' => function () { return 'abc'; },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
