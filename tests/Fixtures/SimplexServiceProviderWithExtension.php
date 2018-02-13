<?php
namespace Simplex\Tests\Fixtures;

use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class SimplexServiceProviderWithExtension implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array();
    }

    public function getExtensions()
    {
        return array(
            'test' => function ($container, $previous) {

                return $previous . 'def';

            },
            'extendNothing' => function ($container, $previous = 'foo') {

                return $previous . 'def';

            },
        );
    }
}
