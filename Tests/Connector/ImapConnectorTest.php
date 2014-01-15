<?php

namespace Digitalshift\MailboxClientBundle\Tests\Connector;

use Digitalshift\MailboxClientBundle\Connection\Connector\ImapConnector;
use Digitalshift\MailboxClientBundle\Tests\BaseTestCase;
use Digitalshift\MailboxClientBundle\Tests\Mocks\FolderFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\ImapLibraryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageHeaderFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageMimePartFactoryMock;

/**
 * ImapConnectorTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapConnectorTest extends BaseTestCase
{
    /**
     * tests folder hydration
     *
     * @depends testGetMessage
     */
    public function testGetFolder()
    {
        $connector = $this->getConnector();
        /** @var \stdClass $folder */
        $folder = $connector->getFolder();

        $this->assertEquals('INBOX', $folder->folderPath);

        $this->assertEquals(
            array('INBOX.sub1', 'INBOX.sub2', 'INBOX.sub3', 'INBOX.sub4'),
            $folder->subfolders
        );

        $this->assertEquals(2, count($folder->messages));
    }

    /**
     * @return ImapConnector
     */
    private function getConnector()
    {
        $userdata = array(
            'user' => '',
            'password' => '',
            'url' => '',
            'port' => '',
            'flags' => array()
        );

        $messageFactoryMock = new MessageFactoryMock(
            new MessageHeaderFactoryMock(),
            new MessageMimePartFactoryMock()
        );

        return new ImapConnector(
            $userdata,
            $messageFactoryMock,
            new FolderFactoryMock($messageFactoryMock),
            new ImapLibraryMock()
        );
    }
} 