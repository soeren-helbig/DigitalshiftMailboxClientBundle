<?php

namespace Digitalshift\MailboxClientBundle\Connection\Connector;

use Digitalshift\MailboxClientBundle\Connection\BaseMailboxConnector;
use Digitalshift\MailboxClientBundle\Connection\MailboxConnectorInterface;
use Digitalshift\MailboxClientBundle\Exception\ImapConnectionException;
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
     * @param MessageFactory $messageFactory
     * @param FolderFactory $folderFactory
     */
    public function __construct(MessageFactory $messageFactory, FolderFactory $folderFactory)
    {
        $this->messageFactory = $messageFactory;
        $this->folderFactory = $folderFactory;
    }

    /**
     * @{inheritdoc}
     */
    public function getFolder($path = null, $recursive = false)
    {
        if ($this->connection) {
            $this->connect();
        }

        $this->setWorkingFolder($path);

        $subfolders = $this->getSubfolders();
        $messages = $this->getMessages();

        return $this->folderFactory->byImapFolderListAndMessageList($path, $subfolders, $messages);
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

        foreach ($this->flags as $flag => $value) {
            $connectionString .= '/' . $flag;

            if (is_string($value) || is_numeric($value)) {
                $connectionString .= '=' . $value;
            }
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
        imap_reopen($this->connection, $path);
    }

    /**
     * @return array
     */
    private function getSubfolders()
    {
        return imap_list($this->connection, $this->buildConnectionString(), '%');
    }

    /**
     * @return array
     */
    private function getMessages()
    {
        $messageHeaders = $this->getFolderOverview();
        $messages = array();

        foreach ($messageHeaders as $messageHeader) {
            $messages[] = $this->getMessageBody($messageHeader['msgno']);
        }
    }

    /**
     * @return array|bool
     */
    private function getFolderOverview()
    {
        $mailboxInfo = imap_check($this->connection);

        if ($this->getMailCount($mailboxInfo) == 0) {
            return false;
        }

        /* get overview of all messages in connected mailbox and return it */
        return imap_fetch_overview(
            $this->connection,
            '1:' . $mailboxInfo->Nmsgs,
            0
        );
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
     * @{inheritdoc}
     */
    public function getMessage($messageId, $path = null)
    {
        if ($this->connection) {
            $this->connect();
        }

        if ($path) {
            $this->setWorkingFolder($path);
        }

        return $this->messageFactory->byRawMessage($this->getMessageBody($messageId));
    }

} 