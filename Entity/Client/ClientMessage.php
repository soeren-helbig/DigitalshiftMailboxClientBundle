<?php

namespace Digitalshift\MailboxClientBundle\Entity;

/**
 * ClientMessage
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ClientMessage
{
    /**
     * @var ClientMessageHeaders
     */
    private $header;

    /**
     * @var ClientMessageMimeParts
     */
    private $rawContent;

    /**
     * @var string
     */
    private $htmlContent;

    /**
     * @var string
     */
    private $plainContent;
} 