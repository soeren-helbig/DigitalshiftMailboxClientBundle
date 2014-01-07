<?php

namespace Digitalshift\MailboxClientBundle\Factory;
use Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders;
use Digitalshift\MailboxClientBundle\Mailbox\MessageMimePart;

/**
 * MessageHeaderFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageHeaderFactory
{
    /**
     * @param string $header
     * @return MessageHeaders
     */
    public function byRawContent($header)
    {
        $headerArray = $this->explodeMessageHeaderText($header);
        $headerArray = $this->getArrayWithKeys($headerArray);

        return $this->byArray($headerArray);
    }

    /**
     * @param string $headerText
     * @return array
     */
    private function explodeMessageHeaderText($headerText)
    {
        $tmpHeader = explode("\r\n",$headerText);
        $header = array();

        foreach ($tmpHeader as $field) {
            if (substr($field,0,1) !== "\t") {
                $header[] = $field;
            } else {
                $headerField = end($header);
                $headerField = $headerField . ' ' . $field;
                $header[count($header)-1] = $headerField;
            }
        }

        return $header;
    }

    /**
     * @param array $headerArray
     * @return array
     */
    public function getArrayWithKeys($headerArray)
    {
        $target = array();

        foreach ($headerArray as $field) {
            preg_match('/^([A-Za-z0-9\-]+):(.+)$/', $field, $matches);

            if (count($matches) === 3) {
                $target[$matches[1]] = trim($matches[2]);
            }
        }

        return $target;
    }

    /**
     * @param array $headers
     * @return MessageHeaders
     */
    public function byArray($headers)
    {
        return new MessageHeaders($headers);
    }

    /**
     * @param MessageMimePart $mimePart
     * @return MessageHeaders
     */
    public function byMimePart(MessageMimePart $mimePart)
    {
        return new MessageHeaders($mimePart->getHeaders());
    }
} 