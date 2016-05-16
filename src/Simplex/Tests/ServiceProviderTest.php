<?php

/*
 * This file is part of Simplex.
 *
 * Copyright (c) 2009 Fabien Potencier
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Simplex\Tests;

use Simplex\Container;
use Simplex\Tests\Fixtures\SimplexServiceProvider;

/**
 * @author Dominik Zogg <dominik.zogg@gmail.com>
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvider()
    {
        $pimple = new Container();

        $pimple->register(new SimplexServiceProvider());

        $this->assertEquals('value', $pimple['param']);
        $this->assertInstanceOf('Simplex\Tests\Fixtures\Service', $pimple['service']);
    }

    public function testProviderWithRegisterMethod()
    {
        $pimple = new Container();

        $pimple->register(new SimplexServiceProvider(), array(
            'anotherParameter' => 'anotherValue',
        ));

        $this->assertEquals('value', $pimple['param']);
        $this->assertEquals('anotherValue', $pimple['anotherParameter']);

        $this->assertInstanceOf('Simplex\Tests\Fixtures\Service', $pimple['service']);
    }

    public function testExtendingValue()
    {
        $pimple = new Container();
        $pimple['previous'] = 'foo';
        $pimple->register(new SimplexServiceProvider());
        $getPrevious = $pimple['previous'];
        $this->assertEquals('foo', $getPrevious());
    }

    public function testExtendingNothing()
    {
        $pimple = new Container();
        $pimple->register(new SimplexServiceProvider());
        $this->assertNull($pimple['previous']);
    }
}
