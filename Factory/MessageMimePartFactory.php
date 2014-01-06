<?php

namespace Digitalshift\MailboxClientBundle\Factory;

use Digitalshift\MailboxClientBundle\Mailbox\MessageMimeParts;

/**
 * MessageMimePartFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageMimePartFactory
{
    /**
     * @var MessageHeaderFactory
     */
    private $messageHeaderFactory;

    /**
     * @param MessageHeaderFactory $messageHeaderFactory
     */
    public function __construct(MessageHeaderFactory $messageHeaderFactory)
    {
        $this->messageHeaderFactory = $messageHeaderFactory;
    }

    /**
     * creates the MessageMimeParts object by the raw content of a mail.
     *
     * @todo: finalize/refactor method
     *
     * @param $content
     * @return MessageMimeParts
     */
    public function byRawContent($content)
    {
        $mailparseResource = $this->initializeMailparse($content);
        $mimePartKeys = $this->getMimePartKeys($mailparseResource);

        return $this->getMimePartsForKeys(
            $mailparseResource,
            $mimePartKeys,
            $content,
            new MessageMimeParts(array())
        );
    }

    /**
     * @param string $content
     * @return resource
     */
    private function initializeMailparse($content)
    {
        $mailparseResource = \mailparse_msg_create();
        mailparse_msg_parse($mailparseResource, $content);

        return $mailparseResource;
    }

    /**
     * @param resource $mailparseResource
     * @return array
     */
    private function getMimePartKeys($mailparseResource)
    {
        return mailparse_msg_get_structure($mailparseResource);
    }

    /**
     * @param resource $resource
     * @param string $key
     * @param string $content
     * @return string
     */
    private function getMimePartHeaderForKey($resource, $key, $content)
    {
        $partResource    = mailparse_msg_get_part($resource, $key);
        $mailparseHeaders = mailparse_msg_get_part_data($partResource);

        return $this->getContentSubstr(
            $content,
            $mailparseHeaders['starting-pos-head'],
            $mailparseHeaders['ending-pos-head']
        );
    }

    /**
     * @param resource $resource
     * @param string $key
     * @param string $content
     * @return string
     */
    private function getMimePartBodyForKey($resource, $key, $content)
    {
        $partResource    = mailparse_msg_get_part($resource, $key);
        $mimePartHeaders = mailparse_msg_get_part_data($partResource);

        return $this->getContentSubstr(
            $content,
            $mimePartHeaders['starting-pos-body'],
            $mimePartHeaders['ending-pos-body']
        );
    }

    /**
     * @todo: finalize/refactor method
     *
     * @param resource $resource
     * @param array $keys
     * @param string $content
     * @param MessageMimeParts $parentPart
     * @return MessageMimeParts
     */
    private function getMimePartsForKeys($resource, $keys, $content, MessageMimeParts $parentPart)
    {
        foreach ($keys as $mimePartKey) {
            $mimePartContent = $this->getMimePartBodyForKey($resource, $mimePartKey, $content);
            $parentPart->addSubpart($mimePartKey, new MessageMimeParts(array(), $mimePartContent));
        }
    }

    /**
     * @param integer $start
     * @param integer $end
     * @return string
     */
    private function getContentSubstr($start, $end)
    {
        return substr($this->rawContent, $start, $end-$start);
    }
} 