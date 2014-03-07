<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks\Connector;

use Digitalshift\MailboxConnectionBundle\Factory\MimeMessageFactory;
use Digitalshift\MailboxConnectionBundle\Entity\Folder;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessage;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessageHeaders;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePartCollection;

/**
 * MessageFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessageFactoryMock extends MimeMessageFactory
{
    /**
     * @{inheritdoc}
     */
    public function byRawMessage($message, $mailboxPath = null, $mailboxUID = null, Folder $folder = null)
    {
        $messageInstance = new MimeMessage(new MimeMessageHeaders(), new MimeMessagePartCollection(), 'INBOX', 123);

        if ($folder) {
            $messageInstance->setMailboxFolder($folder);
        }

        return $messageInstance;
    }
}