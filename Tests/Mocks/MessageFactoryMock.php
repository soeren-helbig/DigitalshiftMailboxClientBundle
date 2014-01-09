<?php

namespace Digitalshift\MailboxClientBundle\Tests\Mocks;

use Digitalshift\MailboxClientBundle\Factory\MessageFactory;

/**
 * MessageFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageFactoryMock extends MessageFactory
{
    /**
     * @{inheritdoc}
     */
    public function byRawMessage($message, Folder $folder = null, $messageId = null)
    {

    }
} 