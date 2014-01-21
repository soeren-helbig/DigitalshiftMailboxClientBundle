<?php

namespace Digitalshift\MailboxConnectionBundle\Exception;

/**
 * ImapConnectionException
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapMailboxException extends \Exception
{
    protected $message = 'Error reading imap mailbox!';
} 