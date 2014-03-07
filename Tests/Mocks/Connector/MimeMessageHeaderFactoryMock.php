<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks\Connector;

use Digitalshift\MailboxConnectionBundle\Factory\MimeMessageHeaderFactory;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePart;

/**
 * MessageHeaderFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessageHeaderFactoryMock extends MimeMessageHeaderFactory
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
    public function byMimePart(MimeMessagePart $mimePart)
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