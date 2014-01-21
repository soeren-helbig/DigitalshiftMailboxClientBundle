<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks;

use Digitalshift\MailboxConnectionBundle\Connection\Connector\ImapLibrary;

/**
 * ImapLibraryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapLibraryMock extends ImapLibrary
{
    /**
     * @{inheritdoc}
     */
    public function imapOpen($connectionString, $username, $password, $flags)
    {
        return true;
    }

    /**
     * @{inheritdoc}
     */
    public function imapReopen($imapResource, $path)
    {
    }

    /**
     * @param resource $imapResource
     * @return bool
     */
    public function imapClose($imapResource)
    {
        return true;
    }

    /**
     * @{inheritdoc}
     */
    public function imapList($imapResource, $mailbox, $pattern)
    {
        return array(
            '{:}INBOX.sub1',
            '{:}INBOX.sub2',
            '{:}INBOX.sub3',
            '{:}INBOX.sub4',
        );
    }

    /**
     * @{inheritdoc}
     */
    public function imapCheck($imapResource)
    {
        $overviewInstance = new \stdClass();
        $overviewInstance->Nmsgs = 2;

        return $overviewInstance;
    }

    /**
     * @{inheritdoc}
     */
    public function imapFetchOverview($imapResource, $sequence, $options)
    {
        return array(
            $this->getImapOverviewObject(1),
            $this->getImapOverviewObject(2),
        );
    }

    private function getImapOverviewObject($messageNumber)
    {
        $overviewInstance = new \stdClass();
        $overviewInstance->msgno = $messageNumber;

        return $overviewInstance;
    }

    /**
     * @{inheritdoc}
     */
    public function imapFetchHeader($imapResource, $messageNumber)
    {
        return $this->loadMessageFixture($messageNumber, true);
    }

    /**
     * @param int $messageNumber
     * @param bool $header
     * @return string
     */
    private function loadMessageFixture($messageNumber = 1, $header = false)
    {
        $basePath = __DIR__.'/../Fixtures/RawMessage/';
        $filePath = $basePath . 'message'.$messageNumber;
        $filePath .= ($header) ? '_header' : '_body';

        $file = fopen($filePath, 'r');
        $fixtureContent = fread($file, filesize($filePath));
        fclose($file);

        return $fixtureContent;
    }

    /**
     * @{inheritdoc}
     */
    public function imapBody($imapResource, $messageNumber)
    {
        return $this->loadMessageFixture($messageNumber);
    }

    /**
     * @{inheritdoc}
     */
    public function imapMailboxMsgInfo($imapResource)
    {
        $mailboxInfo = new \stdClass();
        $mailboxInfo->Mailbox = '{:}INBOX';

        return $mailboxInfo;
    }

} 