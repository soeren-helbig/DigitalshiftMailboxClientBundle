<?php

namespace Digitalshift\MailboxClientBundle\Connection\Connector;

use Digitalshift\MailboxClientBundle\Connection\BaseMailboxConnector;
use Digitalshift\MailboxClientBundle\Connection\MailboxConnectorInterface;
use Digitalshift\MailboxClientBundle\Exception\ImapConnectionException;
use Digitalshift\MailboxClientBundle\Exception\ImapMailboxException;
use Digitalshift\MailboxClientBundle\Factory\FolderFactory;
use Digitalshift\MailboxClientBundle\Factory\MessageFactory;

/**
 * ImapConnector
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapConnector extends BaseMailboxConnector implements MailboxConnectorInterface
{
    const CONNECTION_STRING_PREFIX = '{';
    const CONNECTION_STRING_SUFFIX = '}';

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var FolderFactory
     */
    private $folderFactory;

    /**
     * @param array $userData
     * @param MessageFactory $messageFactory
     * @param FolderFactory $folderFactory
     */
    public function __construct(array $userData, MessageFactory $messageFactory, FolderFactory $folderFactory)
    {
        $this->messageFactory = $messageFactory;
        $this->folderFactory = $folderFactory;

        $this->initialize(
            $userData['user'],
            $userData['password'],
            $userData['url'],
            $userData['port'],
            $userData['flags']
        );
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        if ($this->connection) {
            $this->disconnect();
        }
    }

    /**
     * @return void
     */
    public function disconnect()
    {
        if ($this->connection && imap_close($this->connection)) {
            $this->connection = null;
        }
    }

    /**
     * @{inheritdoc}
     */
    public function getFolder($path = null, $recursive = false)
    {
        if (!$this->connection) {
            $this->connect();
        }

        $this->setWorkingFolder($path);

        $subfolders = $this->getSubfolders($recursive);
        $messages = $this->getMessages();
        $mailboxName = ($path) ? $path : $this->getCurrentMailboxName();

        return $this->folderFactory->byImapFolderListAndMessageList($mailboxName, $subfolders, $messages);
    }

    /**
     * connects to imap mailbox
     *
     * @throws \Digitalshift\MailboxClientBundle\Exception\ImapConnectionException
     */
    private function connect()
    {
        $connectionString = $this->buildConnectionString();

        $this->connection = imap_open(
            $connectionString,
            $this->username,
            $this->password,
            OP_SILENT || OP_DEBUG
        );

        if (!$this->connection) {
            throw new ImapConnectionException();
        }
    }

    /**
     * @return string
     */
    private function buildConnectionString()
    {
        /* build connection string */
        $connectionString = self::CONNECTION_STRING_PREFIX;
        $connectionString .= $this->url;
        $connectionString .= ':';
        $connectionString .= $this->port;

        foreach ($this->flags as $flag) {
            $connectionString .= '/' . $flag;
        }

        $connectionString .= self::CONNECTION_STRING_SUFFIX;

        return $connectionString;
    }

    /**
     * change current mailbox.
     *
     * @param $path
     */
    private function setWorkingFolder($path)
    {
        if ($path) {
            imap_reopen($this->connection, $this->buildConnectionString().$path);
        }
    }

    /**
     * @param boolean $recursive
     * @return array
     */
    private function getSubfolders($recursive = false)
    {
        $pattern = ($recursive) ? '*' : '.%';

        $folderRawNames = imap_list(
            $this->connection,
            $this->buildConnectionString().$this->getCurrentMailboxName(),
            $pattern
        );

        return ($folderRawNames) ? $this->stripFolderNames($folderRawNames) : array();
    }

    /**
     * @param array $folders
     * @return array
     */
    private function stripFolderNames(array $folders)
    {
        $folderList = array();

        foreach ($folders as $folder) {
            $folderList[] = str_replace($this->buildConnectionString(), '', $folder);
        }

        return $folderList;
    }

    /**
     * @return array
     */
    private function getMessages()
    {
        $messageHeaders = $this->getFolderOverview();
        $messages = array();

        foreach ($messageHeaders as $messageHeader) {
            $messages[] = $this->retrieveMessage($messageHeader->msgno);
        }

        return $messages;
    }

    /**
     * @param integer $messageNumber
     * @return \stdClass
     */
    private function retrieveMessage($messageNumber)
    {
        $message = new \stdClass();
        $message->header = $this->getMessageHeader($messageNumber);
        $message->body = $this->getMessageBody($messageNumber);

        return $message;
    }

    /**
     * @return array|bool
     */
    private function getFolderOverview()
    {
        $mailboxInfo = imap_check($this->connection);

        /* get overview of all messages in connected mailbox and return it */
        return imap_fetch_overview(
            $this->connection,
            '1:' . $mailboxInfo->Nmsgs,
            0
        );
    }

    /**
     * @param integer $messageNumber
     * @return array
     */
    private function getMessageHeader($messageNumber)
    {
        return imap_fetchheader($this->connection, $messageNumber);
    }

    /**
     * @param integer $messageNumber
     * @return string
     */
    private function getMessageBody($messageNumber)
    {
        return imap_body(
            $this->connection,
            $messageNumber
        );
    }

    /**
     * @return string
     *
     * @throws ImapMailboxException
     */
    private function getCurrentMailboxName()
    {
        $mailboxInfo = imap_mailboxmsginfo($this->connection);

        if (!$mailboxInfo) {
            throw new ImapMailboxException();
        }

        return $this->hydrateMailboxName($mailboxInfo);
    }

    /**
     * @param string $mailboxInfo
     * @return string mixed
     */
    private function hydrateMailboxName($mailboxInfo)
    {
        // {mail.digitalshift.de:993/imap/notls/ssl/novalidate-cert/user="1000-001@mail.digitalshift.de"}INBOX
        preg_match('/^{.+}(.+)$/', $mailboxInfo->Mailbox, $matches);

        return (count($matches) == 2) ? $matches[1] : '';
    }

    /**
     * @{inheritdoc}
     */
    public function getMessage($messageNumber, $path = null)
    {
        if (!$this->connection) {
            $this->connect();
        }

        if ($path) {
            $this->setWorkingFolder($path);
        }

        return $this->messageFactory->byRawMessage(
            $this->retrieveMessage($messageNumber)
        );
    }

    /**
     * @{inheritdoc}
     */
    public function getType()
    {
        return BaseMailboxConnector::TYPE_IMAP;
    }


} 