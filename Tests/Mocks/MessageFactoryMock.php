<?php

namespace Digitalshift\MailboxClientBundle\Tests\Mocks;

use Digitalshift\MailboxClientBundle\Factory\MessageFactory;
use Digitalshift\MailboxClientBundle\Mailbox\Folder;
use Digitalshift\MailboxClientBundle\Mailbox\Message;
use Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders;
use Digitalshift\MailboxClientBundle\Mailbox\MessageMimePartCollection;

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
        $messageInstance = new Message(new MessageHeaders(), new MessageMimePartCollection());
        $messageInstance->setMailboxFolder($folder);

        return $messageInstance;
    }
}