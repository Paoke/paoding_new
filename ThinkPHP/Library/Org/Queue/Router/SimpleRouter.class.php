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

/**
 * A router that always returns the same queue name for every message.
 *
 * @since   2.0
 */
final class SimpleRouter implements \Org\Queue\Router
{
    /**
     * @var string
     */
    private $queueName;

    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * {@inheritdoc}
     */
    public function queueFor(Message $message)
    {
        return $this->queueName;
    }
}
