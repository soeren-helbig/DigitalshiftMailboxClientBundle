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
    const MIME_TYPE_HTML = 'text/html';
    const MIME_TYPE_PLAIN = 'text/plain';
    const MIME_TYPE_IMAGE = 'image/*';
    const MIME_TYPE_AUDIO = 'audio/*';
    const MIME_TYPE_VIDEO = 'video/*';
    const MIME_TYPE_APPLICATION = 'application/*';

    public static $MIME_TYPE_ATTACHMENT = array(
        self::MIME_TYPE_IMAGE,
        self::MIME_TYPE_AUDIO,
        self::MIME_TYPE_VIDEO,
        self::MIME_TYPE_APPLICATION
    );

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
     * @var \Digitalshift\MailboxClientBundle\Mailbox\MessageMimePartCollection
     */
    private $content;

    /**
     * @param MessageHeaders $header
     * @param MessageMimePartCollection $content
     * @param string $messageId
     * @param Folder $mailboxFolder
     */
    public function __construct(
        MessageHeaders $header,
        MessageMimePartCollection $content,
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
     * @param \Digitalshift\MailboxClientBundle\Mailbox\MessageMimePartCollection $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Mailbox\MessageMimePartCollection
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

    /**
     * hydrate plain-content from mime parts
     *
     * @return string
     */
    public function getPlainContent()
    {
        return $this->getPartsWithType(self::MIME_TYPE_PLAIN);
    }

    /**
     * hydrate html-content from mime parts
     *
     * @return string
     */
    public function getHtmlContent()
    {
        return $this->getPartsWithType(self::MIME_TYPE_HTML);
    }

    /**
     * @param string $mimeType
     * @return string
     */
    private function getPartsWithType($mimeType)
    {
        $content = '';

        /** @var \Digitalshift\MailboxClientBundle\Mailbox\MessageMimePart $mimePart */
        foreach ($this->getContent() as $mimePart) {
            $isHtmlPart = $this->matchesHeaderMimeType(
                $mimePart->getHeader('content-type'),
                array($mimeType)
            );

            $content = ($isHtmlPart) ? $content . $mimePart->decodeContent() : $content;
        }

        return $content;
    }

    /**
     * @param string $mimeType
     * @param array $compareMimeTypes
     * @return bool
     */
    private function matchesHeaderMimeType($mimeType, array $compareMimeTypes)
    {
        $types = $this->getTypeArray($mimeType);

        foreach ($compareMimeTypes as $compareType) {
            $compareTypes = $this->getTypeArray($compareType);

            if (
                $compareTypes['base'] == $types['base'] &&
                (
                    $compareTypes['sub'] == '*' ||
                    $compareTypes['sub'] == $types['sub']
                )
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $type
     * @return array
     */
    private function getTypeArray($type)
    {
        $tmpTypeArray = explode('/', $type);

        return array(
            'base' => $tmpTypeArray[0],
            'sub' => $tmpTypeArray[1]
        );
    }

    /**
     * hydrate attachements from mime parts
     *
     * @return string
     */
    public function getAttachmentMimeParts()
    {
        return $this->getPartsWithAttachment();
    }

    /**
     * @return array
     */
    private function getPartsWithAttachment()
    {
        $parts = array();

        /** @var \Digitalshift\MailboxClientBundle\Mailbox\MessageMimePart $mimePart */
        foreach ($this->getContent() as $mimePart) {
            $isAttachment = $this->matchesHeaderMimeType(
                $mimePart->getHeader('content-type'),
                self::$MIME_TYPE_ATTACHMENT
            );

            ($isAttachment) ? $parts[] = $mimePart : null;
        }

        return $parts;
    }
} 