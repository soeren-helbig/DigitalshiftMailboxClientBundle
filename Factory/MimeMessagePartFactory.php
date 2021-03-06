<?php

namespace Digitalshift\MailboxConnectionBundle\Factory;

use Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePart;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePartCollection;

/**
 * MessageMimePartFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessagePartFactory
{
    /**
     * creates a MimeMessagePartCollection instance by the raw content of a mail.
     *
     * @param $content
     * @return MimeMessagePartCollection
     */
    public function byRawContent($content)
    {
        $mailparseResource = $this->initializeMailparse($content);
        $mimePartKeys = $this->hydrateKeys($mailparseResource);

        return $this->getMimePartCollectionForKeys(
            $mailparseResource,
            $mimePartKeys,
            $content
        );
    }

    /**
     * @param string $content
     * @return resource
     */
    private function initializeMailparse($content)
    {
        $mailparseResource = mailparse_msg_create();
        mailparse_msg_parse($mailparseResource, $content);

        return $mailparseResource;
    }

    /**
     * @param resource $mailparseResource
     * @return array
     */
    private function hydrateKeys($mailparseResource)
    {
        return mailparse_msg_get_structure($mailparseResource);
    }

    /**
     * @param resource $resource
     * @param array $keys
     * @param string $content
     * @return MimeMessagePartCollection
     */
    private function getMimePartCollectionForKeys($resource, $keys, $content)
    {
        $collection = new MimeMessagePartCollection();

        foreach ($keys as $mimePartKey) {
            $collection->offsetSet(
                $mimePartKey,
                $this->getMimePartForKey($resource, $mimePartKey, $content)
            );
        }

        return $collection;
    }

    /**
     * @param resource $resource
     * @param string $key
     * @param string $content
     * @return MimeMessagePart
     */
    private function getMimePartForKey($resource, $key, $content)
    {
        $headers = $this->getMimePartHeaderForKey($resource, $key, $content);
        $content = $this->getMimePartBodyForKey($resource, $key, $content);

        return new MimeMessagePart($headers, $content);
    }

    /**
     * @param resource $resource
     * @param string $key
     * @return string
     */
    private function getMimePartHeaderForKey($resource, $key)
    {
        $partResource = mailparse_msg_get_part($resource, $key);
        $mailparseHeaders = mailparse_msg_get_part_data($partResource);

        return $mailparseHeaders;
    }

    /**
     * @param resource $resource
     * @param string $key
     * @param string $content
     * @return string
     */
    private function getMimePartBodyForKey($resource, $key, $content)
    {
        $partResource = mailparse_msg_get_part($resource, $key);
        $mimePartHeaders = mailparse_msg_get_part_data($partResource);

        return $this->getContentSubstr(
            $content,
            $mimePartHeaders['starting-pos-body'],
            $mimePartHeaders['ending-pos-body']
        );
    }

    /**
     * @param string $content
     * @param integer $start
     * @param integer $end
     * @return string
     */
    private function getContentSubstr($content, $start, $end)
    {
        return substr($content, $start, $end-$start);
    }
} 