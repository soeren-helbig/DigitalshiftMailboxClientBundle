<?php

namespace Digitalshift\MailboxClientBundle\Mailbox;

/**
 * Message
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class Message
{
    /**
     * message id in mailbox
     *
     * @var string
     */
    private $messageId;

    /**
     * parent folder
     *
     * @var Folder
     */
    private $mailboxFolder;

    /**
     * mail headers
     *
     * @var MessageHeaders
     */
    private $header;

    /**
     * mail mime-parts
     *
     * @var MessageMimeParts
     */
    private $content;

    /**
     * @param MessageHeaders $header
     * @param MessageMimeParts $content
     * @param string $messageId
     * @param Folder $mailboxFolder
     */
    public function __construct(
        MessageHeaders $header,
        MessageMimeParts $content,
        $messageId = null,
        Folder $mailboxFolder = null
    ) {
        $this->header = $header;
        $this->content = $content;
        $this->messageId = $messageId;
        $this->mailboxFolder = $mailboxFolder;
    }

    /**
     * hydrate receive-date from headers
     *
     * @todo: implement this method
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
    }

    /**
     * hydrate subject from headers
     *
     * @todo: implement this method
     *
     * @return string
     */
    public function getSubject()
    {
    }

    /**
     * hydrate html-content from mime parts
     *
     * @todo: implement this method
     *
     * @return string
     */
    public function getHtmlContent()
    {
    }

    /**
     * hydrate plain-content from mime parts
     *
     * @todo: implement this method
     *
     * @return string
     */
    public function getPlainContent()
    {
    }

    /**
     * hydrate attachements from mime parts
     *
     * @todo: implement this method
     *
     * @return string
     */
    public function getAttachments()
    {
    }

    /**
     * @param \Digitalshift\MailboxClientBundle\Mailbox\MessageMimeParts $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Mailbox\MessageMimeParts
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param \Digitalshift\MailboxClientBundle\Mailbox\Folder $mailboxFolder
     */
    public function setMailboxFolder($mailboxFolder)
    {
        $this->mailboxFolder = $mailboxFolder;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Mailbox\Folder
     */
    public function getMailboxFolder()
    {
        return $this->mailboxFolder;
    }

    /**
     * @param string $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

} 