<?php

namespace Digitalshift\MailboxClientBundle\Tests\Mocks;

use Digitalshift\MailboxClientBundle\Factory\MessageMimePartFactory;

/**
 * MessageMimePartFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageMimePartFactoryMock extends MessageMimePartFactory
{
    /**
     * @{inheritdoc}
     */
    public function byRawContent($content)
    {

    }

} 