<?php

namespace Digitalshift\MailboxConnectionBundle\Factory;

use Digitalshift\MailboxConnectionBundle\Entity\MimeMessageHeaders;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePart;

/**
 * MessageHeaderFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessageHeaderFactory
{
    /**
     * @param string $header
     * @return MimeMessageHeaders
     */
    public function byRawContent($header)
    {
        return $this->byArray(iconv_mime_decode_headers($header));
    }

    /**
     * @param array $headers
     * @return MimeMessageHeaders
     */
    public function byArray($headers)
    {
        return new MimeMessageHeaders($headers);
    }

    /**
     * @param MimeMessagePart $mimePart
     * @return MimeMessageHeaders
     */
    public function byMimePart(MimeMessagePart $mimePart)
    {
        return new MimeMessageHeaders($mimePart->getHeaders());
    }
} 