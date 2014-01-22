<?php

namespace Digitalshift\MailboxConnectionBundle\Connection;

use Digitalshift\MailboxConnectionBundle\Entity\MailboxFolder;
use Digitalshift\MailboxConnectionBundle\Entity\MailboxMessage;

/**
 * MailboxConnectorInterface
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
interface MailboxConnectorInterface
{
    /**
     * @return void
     */
    public function disconnect();

    /**
     * @param string $path
     * @param bool $recursive
     * @return MailboxFolder
     */
    public function getFolder($path = null, $recursive = false);

    /**
     * @param string $messageNumber
     * @param string $path
     * @param boolean $isUid
     * @return MailboxMessage
     */
    public function getMessage($messageNumber, $path = null, $isUid = false);

    /**
     * @return integer
     */
    public function getType();
} 