<?php

namespace Digitalshift\MailboxConnectionBundle\Factory;

use Digitalshift\MailboxConnectionBundle\Entity\Folder;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessage;

/**
 * MessageFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessageFactory
{
    /**
     * @var MimeMessageHeaderFactory
     */
    private $mimeMessageHeaderFactory;

    /**
     * @var MimeMessagePartFactory
     */
    private $mimeMessagePartFactory;

    /**
     * @param MimeMessageHeaderFactory $mimeMessageHeaderFactory
     * @param MimeMessagePartFactory $mimeMessagePartFactory
     */
    public function __construct(
        MimeMessageHeaderFactory $mimeMessageHeaderFactory,
        MimeMessagePartFactory $mimeMessagePartFactory
    ) {
        $this->mimeMessageHeaderFactory = $mimeMessageHeaderFactory;
        $this->mimeMessagePartFactory = $mimeMessagePartFactory;
    }

    /**
     * creates Message instance of raw mail string.
     *
     * @param \stdClass $message
     * @param Folder $folder
     * @return MimeMessage
     */
    public function byRawMessage($message, $mailboxPath = null, $mailboxUID = null, Folder $folder = null)
    {
        $mimeParts = $this->mimeMessagePartFactory->byRawContent($message->header.$message->body);
        $header = $this->mimeMessageHeaderFactory->byRawContent($message->header);

        return new MimeMessage($header, $mimeParts, $mailboxPath, $mailboxUID, $folder);
    }
}