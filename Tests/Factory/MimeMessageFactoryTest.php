<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Factory;

use Digitalshift\MailboxConnectionBundle\Factory\MimeMessageFactory;
use Digitalshift\MailboxConnectionBundle\Tests\BaseTestCase;
use Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory\MimeMessageHeaderFactoryMock;
use Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory\MimeMessagePartFactoryMock;

/**
 * MimeMessageFactoryTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessageFactoryTest extends BaseTestCase
{
    const FIXTURES_BASE_PATH = '../Fixtures';

    /**
     * @dataProvider byRawMessageProvider
     *
     * @param string $headerFile
     * @param string $contentFile
     */
    public function testByRawMessage(
        $headerFile,
        $contentFile
    ) {
        $expectedHeader = $this->loadFixtureFromFile($headerFile);
        $expectedContent = $this->loadFixtureFromFile($contentFile);

        $messageFactory = $this->getMessageFactory($headerFile, $contentFile);
        $message = $messageFactory->byRawMessage($this->getRawMessage());

        $this->assertEquals($expectedHeader, $message->getHeader());
        $this->assertEquals($expectedContent, $message->getContent());
    }

    /**
     * @return array
     */
    public function byRawMessageProvider()
    {
        return array(
            array(
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MimeMessageHeaders/mimeMessageHeaders_1',
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MimeMessageParts/mimeMessagePartCollection_1',
            ),
            array(
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MimeMessageHeaders/mimeMessageHeaders_2',
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MimeMessageParts/mimeMessagePartCollection_2',
            )
        );
    }

    /**
     * @param string $headerFile
     * @param string $contentFile
     * @return MimeMessageFactory
     */
    private function getMessageFactory($headerFile, $contentFile)
    {
        $messageHeaderFactoryMock = new MimeMessageHeaderFactoryMock();
        $messageHeaderFactoryMock->setSourceFile($headerFile);

        $messageMimePartFactoryMock = new MimeMessagePartFactoryMock();
        $messageMimePartFactoryMock->setSourceFile($contentFile);

        return new MimeMessageFactory($messageHeaderFactoryMock, $messageMimePartFactoryMock);
    }

    /**
     * @return \stdClass
     */
    private function getRawMessage()
    {
        $message = new \stdClass();
        $message->header = '';
        $message->body = '';
        $message->mailboxPath = '';
        $message->mailboxUid = '';

        return $message;
    }

    /**
     * @param $filePath
     * @return mixed
     */
    private function loadFixtureFromFile($filePath)
    {
        $file = fopen($filePath, 'r');
        $instanceData = fread($file, filesize($filePath));
        fclose($file);

        return unserialize($instanceData);
    }

} 