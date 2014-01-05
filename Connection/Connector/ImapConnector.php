<?php

namespace Digitalshift\MailboxClientBundle\Connection\Connector;

use Digitalshift\MailboxClientBundle\Connection\BaseMailboxConnector;
use Digitalshift\MailboxClientBundle\Connection\MailboxConnectorInterface;

/**
 * ImapConnector
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapConnector extends BaseMailboxConnector implements MailboxConnectorInterface
{
    /**
     * @{inheritdoc}
     */
    public function getFolder($name = null, $recursive = false)
    {
        // TODO: Implement getFolder() method.
    }

    /**
     * @{inheritdoc}
     */
    public function getMessage($messageId, $folder = null)
    {
        // TODO: Implement getMessage() method.
    }

} 