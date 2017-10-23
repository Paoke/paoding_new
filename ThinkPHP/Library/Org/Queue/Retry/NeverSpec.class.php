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

namespace Org\Queue\Retry;

use Org\Queue\Envelope;
use Org\Queue\RetrySpec;

/**
 * Never retry a message.
 *
 * @since   2.0
 */
final class NeverSpec implements RetrySpec
{
    /**
     * {@inheritdoc}
     */
    public function canRetry(Envelope $env)
    {
        return false;
    }
}
