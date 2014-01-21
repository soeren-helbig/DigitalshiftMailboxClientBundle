<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks;

use Digitalshift\MailboxConnectionBundle\Factory\MessageFactory;
use Digitalshift\MailboxConnectionBundle\Mailbox\Folder;
use Digitalshift\MailboxConnectionBundle\Mailbox\Message;
use Digitalshift\MailboxConnectionBundle\Mailbox\MessageHeaders;
use Digitalshift\MailboxConnectionBundle\Mailbox\MessageMimePartCollection;

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