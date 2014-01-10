<?php

namespace Digitalshift\MailboxClientBundle\Tests\Mocks;

use Digitalshift\MailboxClientBundle\Factory\MessageHeaderFactory;

/**
 * MessageHeaderFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageHeaderFactoryMock extends MessageHeaderFactory
{
    /**
     * @{inheritdoc}
     */
    public function byRawContent($header)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function byArray($headers)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function byMimePart(MessageMimePart $mimePart)
    {

    }
} 