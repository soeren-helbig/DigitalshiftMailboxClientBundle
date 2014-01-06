<?php

namespace Digitalshift\MailboxClientBundle\Mailbox;

use Digitalshift\MailboxClientBundle\Exception\HeaderNotInitializedException;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * MessageMimeParts encapsulates the mail mime parts as key / value pairs.
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageMimeParts
{
    private $headers;

    private $content;

    private $subparts;

    public function __construct(array $headers, $content = null, array $subparts = array())
    {
        $this->headers = $headers;
        $this->content = $content;
        $this->subparts = $subparts;
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

        /* convert charset to utf-8 and return the string*/
        return ($bodyEncoding) ? mb_convert_encoding($body, 'utf-8', $bodyEncoding) : $body;
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
     * @param string $key
     * @param MessageMimeParts $subpart
     */
    public function addSubpart($key, MessageMimeParts $subpart)
    {
        $this->subparts[$key] = $subpart;
    }

    /**
     * @param array $subparts
     */
    public function setSubparts(array $subparts)
    {
        $this->subparts = $subparts;
    }

    /**
     * @return array
     */
    public function getSubparts()
    {
        return $this->subparts;
    }

    /**
     * @return bool
     */
    public function hasSubparts()
    {
        return (count($this->subparts) > 0) ? true : false;
    }
} 