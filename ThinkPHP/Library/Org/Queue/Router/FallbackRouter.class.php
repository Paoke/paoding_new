<?php
/**
 * This file is part of Org\Queue
 *
 * Copyright (c) PMG <https://www.pmg.com>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 *
 * @license     http://opensource.org/licenses/Apache-2.0 Apache-2.0
 */

namespace Org\Queue\Router;

use Org\Queue\Message;
use Org\Queue\Router;

/**
 * A decorator that wraps another router and returns a fallback queue
 * name if one isn't found.
 *
 * @since   2.0
 */
final class FallbackRouter implements \Org\Queue\Router
{
    /**
     * @var Router
     */
    private $wrapped;

    /**
     * @var string
     */
    private $fallbackQueue;

    public function __construct(Router $wrapped, $fallbackQueue)
    {
        $this->wrapped = $wrapped;
        $this->fallbackQueue = $fallbackQueue;
    }

    /**
     * {@inheritdoc}
     */
    public function queueFor(Message $message)
    {
        return $this->wrapped->queueFor($message) ?: $this->fallbackQueue;
    }
}
