<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks;

use Digitalshift\MailboxAbstractionBundle\Factory\MessageFactory;
use Digitalshift\MailboxAbstractionBundle\Entity\Folder;
use Digitalshift\MailboxAbstractionBundle\Entity\Message;
use Digitalshift\MailboxAbstractionBundle\Entity\MessageHeaders;
use Digitalshift\MailboxAbstractionBundle\Entity\MessageMimePartCollection;

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