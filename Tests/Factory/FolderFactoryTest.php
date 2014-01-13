<?php

namespace Digitalshift\MailboxClientBundle\Tests\Factory;

use Digitalshift\MailboxClientBundle\Factory\FolderFactory;
use Digitalshift\MailboxClientBundle\Mailbox\Folder;
use Digitalshift\MailboxClientBundle\Mailbox\FolderCollection;
use Digitalshift\MailboxClientBundle\Mailbox\Message;
use Digitalshift\MailboxClientBundle\Tests\BaseTestCase;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageHeaderFactoryMock;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageMimePartFactoryMock;

/**
 * FolderFactoryTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class FolderFactoryTest extends BaseTestCase
{
    /**
     * @dataProvider byImapFolderListAndMessageListProvider
     *
     * @param string $expectedFolderPath
     * @param string $expectedFolderName
     * @param FolderCollection $expectedSubfolders
     * @param string $folderPath
     * @param array $subfolders
     */
    public function testByImapFolderListAndMessageList(
        $expectedFolderPath,
        $expectedFolderName,
        $expectedSubfolders,
        $folderPath,
        $subfolders
    ) {
        $folderFactory = $this->getFolderFactory();
        $folder = $folderFactory->byImapFolderListAndMessageList($folderPath, $subfolders, array('', ''));

        $this->assertEquals($expectedSubfolders, $folder->getFolders());
        $this->assertEquals($expectedFolderPath, $folder->getPath());
        $this->assertEquals($expectedFolderName, $folder->getName());

        /** @var $message Message */
        foreach ($folder->getMessages() as $message) {
            $this->assertEquals($expectedFolderName, $message->getMailboxFolder()->getName());
        }
    }

    /**
     * @return array
     */
    public function byImapFolderListAndMessageListProvider()
    {
        return array(
            array(
                'INBOX',
                'INBOX',
                $this->getExpectedSubfolders(array('subfolder1', 'subfolder2', 'subfolder3', 'subfolder4', 'subfolder5')),
                'INBOX',
                array('subfolder1', 'subfolder2', 'subfolder3', 'subfolder4', 'subfolder5')
            ),
            array(
                'INBOX.sub1',
                'sub1',
                $this->getExpectedSubfolders(array('subfolder1', 'subfolder2', 'subfolder3', 'subfolder4', 'subfolder5')),
                'INBOX.sub1',
                array('subfolder1', 'subfolder2', 'subfolder3', 'subfolder4', 'subfolder5')
            ),
        );
    }

    /**
     * @param array $subfolders
     * @return FolderCollection
     */
    private function getExpectedSubfolders(array $subfolders)
    {
        $folders = array();

        foreach ($subfolders as $subfolder) {
            $folderInstance = new Folder();
            $folderInstance->setName($subfolder);
            $folderInstance->setPath($subfolder);
            $folders[] = $folderInstance;
        }

        return new FolderCollection($folders);
    }

    /**
     * @return FolderFactory
     */
    private function getFolderFactory()
    {
        $messageHeaderFactoryMock = new MessageHeaderFactoryMock();
        $messageMimePartFactoryMock = new MessageMimePartFactoryMock();
        $messageFactoryMock = new MessageFactoryMock($messageHeaderFactoryMock, $messageMimePartFactoryMock);

        return new FolderFactory($messageFactoryMock);
    }
} 