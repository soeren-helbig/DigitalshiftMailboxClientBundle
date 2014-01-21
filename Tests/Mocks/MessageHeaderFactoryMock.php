<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks;

use Digitalshift\MailboxConnectionBundle\Factory\MessageHeaderFactory;
use Digitalshift\MailboxConnectionBundle\Mailbox\MessageHeaders;

/**
 * MessageHeaderFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageHeaderFactoryMock extends MessageHeaderFactory
{
    /**
     * file to read serialized MessageHeaders-instance data
     *
     * @var string
     */
    private $sourceFile;

    /**
     * @{inheritdoc}
     */
    public function byRawContent($header)
    {
        return $this->getDataFromFile();
    }

    /**
     * @{inheritdoc}
     */
    public function byArray($headers)
    {
        return $this->getDataFromFile();
    }

    /**
     * @{inheritdoc}
     */
    public function byMimePart(MessageMimePart $mimePart)
    {
        return $this->getDataFromFile();
    }

    /**
     * @return MessageHeaders
     */
    private function getDataFromFile()
    {
        $file = fopen($this->sourceFile, 'r');
        $instanceData = fread($file, filesize($this->sourceFile));
        fclose($file);

        return unserialize($instanceData);
    }

    /**
     * @param string $sourceFile
     */
    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;
    }

    /**
     * @return string
     */
    public function getSourceFile()
    {
        return $this->sourceFile;
    }

} 