<?php

namespace Digitalshift\MailboxClientBundle\Entity;

/**
 * MailboxMessage
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MailboxMessage
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $content;

    /**
     * @var MailboxFolder
     */
    private $folder;

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Digitalshift\MailboxClientBundle\Entity\MailboxFolder $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Entity\MailboxFolder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
} 