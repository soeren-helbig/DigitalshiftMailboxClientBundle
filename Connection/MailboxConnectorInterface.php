<?php

namespace Digitalshift\MailboxClientBundle\Connection;

use Digitalshift\MailboxClientBundle\Entity\MailboxFolder;
use Digitalshift\MailboxClientBundle\Entity\MailboxMessage;

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
     * @return MailboxMessage
     */
    public function getMessage($messageNumber, $path = null);

    /**
     * @return integer
     */
    public function getType();
} 