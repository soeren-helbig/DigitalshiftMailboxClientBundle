<?php

namespace Digitalshift\MailboxClientBundle\Factory;
use Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders;

/**
 * MessageHeaderFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageHeaderFactory
{
    /**
     * @todo: implement this method
     *
     * @return MessageHeaders
     */
    public function byRawContent()
    {
        return new MessageHeaders();
    }

    /**
     * @todo: implement this method
     *
     * @return MessageHeaders
     */
    public function byMimePart()
    {
        return new MessageHeaders();
    }
} 