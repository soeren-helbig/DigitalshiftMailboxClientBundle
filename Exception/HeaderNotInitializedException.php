<?php

namespace Digitalshift\MailboxConnectionBundle\Exception;

/**
 * HeaderNotInitializedException
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class HeaderNotInitializedException extends \Exception
{
    protected $message = 'Header is not initialized!';
} 