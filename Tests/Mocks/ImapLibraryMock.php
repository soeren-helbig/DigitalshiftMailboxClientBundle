<?php

namespace Digitalshift\MailboxClientBundle\Tests\Mocks;

use Digitalshift\MailboxClientBundle\Connection\Connector\ImapLibrary;

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

    }

    /**
     * @{inheritdoc}
     */
    public function imapList($imapResource, $mailbox, $pattern)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function imapCheck($imapResource)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function imapFetchOverview($imapResource, $sequence, $options)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function imapFetchHeader($imapResource, $messageNumber)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function imapBody($imapResource, $messageNumber)
    {

    }

    /**
     * @{inheritdoc}
     */
    public function imapMailboxMsgInfo($imapResource)
    {

    }

} 