<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory;

use Digitalshift\MailboxConnectionBundle\Factory\MimeMessagePartFactory;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessageHeaders;

/**
 * MessageMimePartFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessagePartFactoryMock extends MimeMessagePartFactory
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
    public function byRawContent($content)
    {
        return $this->getDataFromFile();
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

} 