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
     * @param string $name
     * @param bool $recursive
     * @return MailboxFolder
     */
    public function getFolder($name = null, $recursive = false);

    /**
     * @param string $messageId
     * @param string $folder
     * @return MailboxMessage
     */
    public function getMessage($messageId, $folder = null);
} 