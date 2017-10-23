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

use Org\Queue\QueueException;

/**
 * Thrown when there's some trouble serializing or unserializing messages.
 *
 * @since   2.0
 */
final class SerializationError extends \RuntimeException implements DriverError
{

}
