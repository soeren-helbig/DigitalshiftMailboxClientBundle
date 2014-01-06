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
     * @var MessageHeaderFactory
     */
    private $messageHeaderFactory;

    /**
     * @var MessageMimePartFactory
     */
    private $messageMimePartsFactory;

    /**
     * @param $messageHeaderFactory $messageHeaderFactory
     * @param MessageMimePartFactory $messageMimePartFactory
     */
    public function __construct(
        MessageHeaderFactory $messageHeaderFactory,
        MessageMimePartFactory $messageMimePartFactory
    ) {
        $this->messageHeaderFactory = $messageHeaderFactory;
        $this->messageMimePartsFactory = $messageMimePartFactory;
    }

    /**
     * creates Message instance of raw mail string.
     *
     * @param $message
     * @param string $messageId
     * @param string $folder
     * @return Message
     */
    public function byRawMessage($message, $messageId = null, $folder = null)
    {
        return new Message(
            $this->messageHeaderFactory->byRawContent($message),
            $this->messageMimePartsFactory->byRawContent($message),
            $messageId,
            $folder
        );
    }
}