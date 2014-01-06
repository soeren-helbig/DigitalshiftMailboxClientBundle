<?php

namespace Digitalshift\MailboxClientBundle\Exception;

/**
 * ImapConnectionException
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapConnectionException extends \Exception
{
    protected $message = 'Error connection to imap mailbox!';
} 