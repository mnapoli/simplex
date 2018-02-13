[![Build Status](https://travis-ci.org/mnapoli/simplex.svg?branch=master)](https://travis-ci.org/mnapoli/simplex)

# Simplex

Simplex is a [Pimple 3](https://github.com/silexphp/Pimple) fork with full [container-interop](https://github.com/container-interop/container-interop) compliance and [cross-framework service-provider](https://github.com/container-interop/service-provider) support.

Simplex is a small dependency injection container for PHP.

## Differences with Pimple

Simplex is a fork of Pimple's code. The only differences are the following:

- `Simplex\Container` implements [`ContainerInterface`](https://github.com/container-interop/container-interop/blob/master/src/Interop/Container/ContainerInterface.php), which means the following methods exist:
    - `$container->get($id)` which is an alias to `$container[$id]`
    - `$container->has($id)` which is an alias to `isset($container[$id])`
- for symmetry reasons, `Simplex\Container` also provides an additional method:
    - `$container->set($id, $value)` which is an alias to `$container[$id] = ...`
- the constructor takes an optional `ContainerInterface $rootContainer = null` argument to support the [delegate lookup feature](https://github.com/container-interop/container-interop/blob/master/docs/Delegate-lookup.md): if provided, this container will be injected in factories instead
- service providers have been completely replaced by [container-interop's service providers](https://github.com/container-interop/service-provider): that allows to load cross-framework modules in this container
- it is possible to extend a scalar value with `$container->extend()` (for compatibility reasons with cross-framework service providers)

Below is the documentation of Pimple/Simplex.

# Installation

```
composer require mnapoli/simplex
```

# Usage

Creating a container is a matter of creating a `Container` instance:

```php
$container = new \Simplex\Container();
```

## Defining Services

A service is an object that does something as part of a larger system. Examples
of services: a database connection, a templating engine, or a mailer. Almost
any **global** object can be a service.

Services are defined by **anonymous functions** that return an instance of an
object:

```php
// define some services
$container['session_storage'] = function ($c) {
    return new SessionStorage('SESSION_ID');
};

$container['session'] = function ($c) {
    return new Session($c['session_storage']);
};
```

Notice that the anonymous function has access to the current container
instance, allowing references to other services or parameters.

As objects are only created when you get them, the order of the definitions
does not matter.

Using the defined services is also very easy:

```php
// get the session object
$session = $container['session'];

// the above call is roughly equivalent to the following code:
// $storage = new SessionStorage('SESSION_ID');
// $session = new Session($storage);
```

## Defining Factory Services

By default, each time you get a service, Pimple returns the **same instance**
of it. If you want a different instance to be returned for all calls, wrap your
anonymous function with the `factory()` method

```php
$container['session'] = $container->factory(function ($c) {
    return new Session($c['session_storage']);
});
```

Now, each call to ``$container['session']`` returns a new instance of the
session.

## Defining Parameters

Defining a parameter allows to ease the configuration of your container from
the outside and to store global values:

```php
// define some parameters
$container['cookie_name'] = 'SESSION_ID';
$container['session_storage_class'] = 'SessionStorage';
```

If you change the `session_storage` service definition like below:

```php
$container['session_storage'] = function ($c) {
    return new $c['session_storage_class']($c['cookie_name']);
};
```

You can now easily change the cookie name by overriding the
`session_storage_class` parameter instead of redefining the service
definition.

## Protecting Parameters

Because Pimple sees anonymous functions as service definitions, you need to
wrap anonymous functions with the `protect()` method to store them as
parameters:

```php
$container['random_func'] = $container->protect(function () {
    return rand();
});
```

## Modifying Services after Definition

In some cases you may want to modify a service definition after it has been
defined. You can use the `extend()` method to define additional code to be
run on your service just after it is created:

```php
$container['session_storage'] = function ($c) {
    return new $c['session_storage_class']($c['cookie_name']);
};

$container->extend('session_storage', function ($storage, $c) {
    $storage->...();

    return $storage;
});
```

The first argument is the name of the service to extend, the second a function
that gets access to the object instance and the container.

## Service providers

Simplex supports registering [cross-framework service providers](https://github.com/container-interop/service-provider).

To register service providers, pass an array of service providers as first constructor argument.

```php
$container = new \Simplex\Container([new MyServiceProvider()]);
```
