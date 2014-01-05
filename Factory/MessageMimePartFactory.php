<?php

namespace Digitalshift\MailboxClientBundle\Factory;

use Digitalshift\MailboxClientBundle\Mailbox\MessageMimeParts;

/**
 * MessageMimePartFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageMimePartFactory
{
    /**
     * creates the MessageMimeParts object by the raw content of a mail.
     *
     * @param $content
     * @return MessageMimeParts
     */
    public function byRawContent($content)
    {
        return new MessageMimeParts(array());
    }
} 