<?php

namespace Digitalshift\MailboxClientBundle\Tests\Factory;

use Digitalshift\MailboxClientBundle\Factory\MessageFactory;
use Digitalshift\MailboxClientBundle\Mailbox\MessageHeaders;
use Digitalshift\MailboxClientBundle\Mailbox\MessageMimePartCollection;
use Digitalshift\MailboxClientBundle\Tests\BaseTestCase;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageHeaderFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageMimePartFactoryMock;

/**
 * MessageFactoryTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageFactoryTest extends BaseTestCase
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
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MessageHeaders/messageHeaders_1',
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MessageMimeParts/messageMimePartCollection_1',
            ),
            array(
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MessageHeaders/messageHeaders_2',
                __DIR__.'/'.self::FIXTURES_BASE_PATH.'/MessageMimeParts/messageMimePartCollection_2',
            )
        );
    }

    /**
     * @param string $headerFile
     * @param string $contentFile
     * @return MessageFactory
     */
    private function getMessageFactory($headerFile, $contentFile)
    {
        $messageHeaderFactoryMock = new MessageHeaderFactoryMock();
        $messageHeaderFactoryMock->setSourceFile($headerFile);

        $messageMimePartFactoryMock = new MessageMimePartFactoryMock();
        $messageMimePartFactoryMock->setSourceFile($contentFile);

        return new MessageFactory($messageHeaderFactoryMock, $messageMimePartFactoryMock);
    }

    /**
     * @return \stdClass
     */
    private function getRawMessage()
    {
        $message = new \stdClass();
        $message->header = '';
        $message->body = '';

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