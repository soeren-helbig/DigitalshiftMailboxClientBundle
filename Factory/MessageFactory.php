<?php

namespace Digitalshift\MailboxClientBundle\Factory;
use Digitalshift\MailboxClientBundle\Mailbox\Folder;
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
     * @param \stdClass $message
     * @param Folder $folder
     * @param string $messageId
     * @return Message
     */
    public function byRawMessage($message, Folder $folder = null, $messageId = null)
    {
        $mimeParts = $this->messageMimePartsFactory->byRawContent($message->header.$message->body);
        $header = $this->messageHeaderFactory->byRawContent($message->header);

        return new Message($header, $mimeParts, $messageId, $folder);
    }
}