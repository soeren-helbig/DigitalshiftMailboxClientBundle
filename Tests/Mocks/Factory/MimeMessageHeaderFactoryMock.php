<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory;

use Digitalshift\MailboxConnectionBundle\Factory\MimeMessageHeaderFactory;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessageHeaders;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePart;

/**
 * MimeMessageHeaderFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessageHeaderFactoryMock extends MimeMessageHeaderFactory
{
    /**
     * file to read serialized MimeMessageHeaders-instance data
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
     * @return MimeMessageHeaders
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