<?php

namespace Digitalshift\MailboxClientBundle\Tests\Connector;

use Digitalshift\MailboxClientBundle\Connection\Connector\ImapConnector;
use Digitalshift\MailboxClientBundle\Tests\BaseTestCase;
use Digitalshift\MailboxClientBundle\Tests\Mocks\FolderFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\ImapLibraryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageHeaderFactoryMock;

/**
 * ImapConnectorTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapConnectorTest extends BaseTestCase
{
    /**
     * tests message hydration
     */
    public function testGetMessage()
    {
//        $connector = $this->getConnector();
//
//        $message = $connector->getMessage(1);
    }

    /**
     * tests folder hydration
     *
     * @depends testGetMessage
     */
    public function testGetFolder()
    {
        $connector = $this->getConnector();

        $folder = $connector->getFolder();
    }

    /**
     * @return ImapConnector
     */
    private function getConnector()
    {
        $userdata = array();
        $messageFactoryMock = new MessageFactoryMock(
            new MessageHeaderFactoryMock(),
            new MessageHeaderFactoryMock()
        );

        return new ImapConnector(
            $userdata,
            $messageFactoryMock,
            new FolderFactoryMock($messageFactoryMock),
            new ImapLibraryMock()
        );
    }
} 