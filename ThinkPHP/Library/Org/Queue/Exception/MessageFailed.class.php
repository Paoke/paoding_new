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

namespace Org\Queue\Exception;

use Org\Queue\Message;
use Org\Queue\QueueException;

/**
 * Thrown by the consumer to indicate a message failure.
 *
 * @since   2.0
 */
final class MessageFailed extends \Exception implements QueueException
{
    private $queueMessage;

    public function __construct(\Exception $cause, Message $message)
    {
        parent::__construct($cause->getMessage(), $cause->getCode(), $cause);
        $this->queueMessage = $message;
    }

    public function getQueueMessage()
    {
        return $this->queueMessage;
    }
}
