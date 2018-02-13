<?php

namespace Simplex\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * No entry was found in the container.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class EntryNotFound extends \Exception implements NotFoundExceptionInterface
{
    public function __construct($id)
    {
        parent::__construct(sprintf('Identifier "%s" is not defined.', $id));
    }
}
