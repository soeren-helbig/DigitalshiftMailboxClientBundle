<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Factory;

use Digitalshift\MailboxConnectionBundle\Factory\FolderFactory;
use Digitalshift\MailboxConnectionBundle\Entity\Folder;
use Digitalshift\MailboxConnectionBundle\Entity\FolderCollection;
use Digitalshift\MailboxConnectionBundle\Entity\MimeMessage;
use Digitalshift\MailboxConnectionBundle\Tests\BaseTestCase;
use Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory\MimeMessageFactoryMock;
use Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory\MimeMessageHeaderFactoryMock;
use Digitalshift\MailboxConnectionBundle\Tests\Mocks\Factory\MimeMessagePartFactoryMock;

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

        /** @var $message MimeMessage */
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
        $messageHeaderFactoryMock = new MimeMessageHeaderFactoryMock();
        $messageMimePartFactoryMock = new MimeMessagePartFactoryMock();
        $messageFactoryMock = new MimeMessageFactoryMock($messageHeaderFactoryMock, $messageMimePartFactoryMock);

        return new FolderFactory($messageFactoryMock);
    }
} 