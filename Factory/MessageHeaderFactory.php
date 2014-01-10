<?php

namespace Digitalshift\MailboxClientBundle\Factory;
use Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders;
use Digitalshift\MailboxClientBundle\Mailbox\MessageMimePart;

/**
 * MessageHeaderFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageHeaderFactory
{
    /**
     * @param string $header
     * @return MessageHeaders
     */
    public function byRawContent($header)
    {
        return $this->byArray(iconv_mime_decode_headers($header));
    }

    /**
     * @param array $headers
     * @return MessageHeaders
     */
    public function byArray($headers)
    {
        return new MessageHeaders($headers);
    }

    /**
     * @param MessageMimePart $mimePart
     * @return MessageHeaders
     */
    public function byMimePart(MessageMimePart $mimePart)
    {
        return new MessageHeaders($mimePart->getHeaders());
    }
} 