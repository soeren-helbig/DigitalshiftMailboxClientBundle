<?php

namespace Digitalshift\MailboxConnectionBundle\Entity;

use Digitalshift\MailboxConnectionBundle\Exception\HeaderNotInitializedException;

/**
 * MessageMimeParts encapsulates the mail mime parts as key / value pairs.
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessagePart
{
    public static $MIME_TYPE_ATTACHMENT = array(
        MimeMessage::MIME_TYPE_IMAGE,
        MimeMessage::MIME_TYPE_AUDIO,
        MimeMessage::MIME_TYPE_VIDEO,
        MimeMessage::MIME_TYPE_APPLICATION
    );

    /**
     * path where content is persisted
     *
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $content;

    /**
     * @param array $headers
     * @param string $content
     */
    public function __construct(array $headers, $content = null)
    {
        $this->headers = $headers;
        $this->content = $content;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function decodeContent()
    {
        $content = $this->getContent();
        $transferEncoding = strtoupper($this->getHeader('transfer-encoding'));
        $bodyEncoding = $this->getHeader('charset');

        $body = ($transferEncoding ) ? $this->decodeTransferEncoding($content, $transferEncoding) : $content;

        /* convert charset to utf-8 (if not an attachment) */
        return ($bodyEncoding && !$this->isAttachment()) ? mb_convert_encoding($body, 'utf-8', $bodyEncoding) : $body;
    }

    /**
     * decodes mime parts with different transfer encodings. possible transfer-encodings:
     * - BASE64
     * - QUOTED-PRINTABLE
     * - 7BIT (do not need any decoding)
     * - 8BIT (do not need any decoding)
     *
     * @param $content
     * @param string $transferEncoding
     * @return string
     */
    private function decodeTransferEncoding($content, $transferEncoding = null)
    {
        $partContent = $content;

        if ($transferEncoding === 'BASE64') {
            $partContent = imap_base64($content);
        } else if ($transferEncoding === 'QUOTED-PRINTABLE') {
            $partContent = quoted_printable_decode($content);
        }

        return $partContent;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $key
     * @return string
     *
     * @throws HeaderNotInitializedException
     */
    public function getHeader($key)
    {
        if (!is_array($this->headers) || !array_key_exists($key, $this->headers)) {
            throw new HeaderNotInitializedException();
        }

        return $this->headers[$key];
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @throws HeaderNotInitializedException
     */
    public function setHeader($key, $value)
    {
        if (!is_array($this->headers)) {
            throw new HeaderNotInitializedException();
        }

        $this->headers[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function isHeaderSet($key)
    {
        return (is_array($this->headers) && array_key_exists($key, $this->headers))
            ? true
            : false;
    }

    /**
     * @return bool
     */
    public function isAttachment()
    {
        $type = $this->getHeader('content-type');
        $types = explode('/', $type);

        foreach (self::$MIME_TYPE_ATTACHMENT as $attachmentType) {
            $attachmentTypes = explode('/', $attachmentType);

            if ($types[0] == $attachmentTypes[0]) {
                return true;
            }
        }

        return false;
    }

} 