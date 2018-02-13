<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class SimplexServiceProviderWithFactory implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array(
            'test' => function () { return 'abc'; },
        );
    }

    public function getExtensions()
    {
        return array();
    }
}
