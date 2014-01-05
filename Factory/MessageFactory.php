<?php

namespace Digitalshift\MailboxClientBundle\Factory;
use Digitalshift\MailboxClientBundle\Mailbox\Message;

/**
 * MessageFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageFactory
{
    /**
     * @var MessageMimePartFactory
     */
    private $messageMimePartsFactory;

    /**
     * @param MessageMimePartFactory $messageMimePartFactory
     */
    public function __construct(MessageMimePartFactory $messageMimePartFactory)
    {
        $this->messageMimePartsFactory = $messageMimePartFactory;
    }

    /**
     * creates Message instance of raw mail string.
     *
     * @param $message
     * @return Message
     */
    public function byRawMessage($message)
    {
        return new Message();
    }

    /**
     * @param $content
     * @param array $headers
     * @return Message
     */
    public function byRawContentAndHeader($content, array $headers)
    {
        return new Message();
    }
}