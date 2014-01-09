<?php

namespace Digitalshift\MailboxClientBundle\Connection\Connector;

/**
 * ImapLibrary
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapLibrary
{
    /**
     * @param string $connectionString
     * @param string $username
     * @param string $password
     * @param integer $flags
     * @return resource
     */
    public function imapOpen($connectionString, $username, $password, $flags)
    {
        return imap_open($connectionString, $username, $password, $flags);
    }

    /**
     * @param resource $imapResource
     * @param string $mailbox
     * @param string $pattern
     * @return array
     */
    public function imapList($imapResource, $mailbox, $pattern)
    {
        return imap_list($imapResource, $mailbox, $pattern);
    }

    /**
     * @param resource $imapResource
     * @return object
     */
    public function imapCheck($imapResource)
    {
        return imap_check($imapResource);
    }

    /**
     * @param resource $imapResource
     * @param string $sequence
     * @param integer $options
     * @return array
     */
    public function imapFetchOverview($imapResource, $sequence, $options)
    {
        return imap_fetch_overview($imapResource, $sequence, $options);
    }

    /**
     * @param resource $imapResource
     * @param integer $messageNumber
     * @return string
     */
    public function imapFetchHeader($imapResource, $messageNumber)
    {
        return imap_fetchheader($imapResource, $messageNumber);
    }

    /**
     * @param resource $imapResource
     * @param integer $messageNumber
     * @return string
     */
    public function imapBody($imapResource, $messageNumber)
    {
        return imap_body($imapResource, $messageNumber);
    }

    /**
     * @param resource $imapResource
     * @return object
     */
    public function imapMailboxMsgInfo($imapResource)
    {
        return imap_mailboxmsginfo($imapResource);
    }
} 