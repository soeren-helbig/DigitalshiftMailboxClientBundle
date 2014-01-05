<?php

namespace Digitalshift\MailboxClientBundle\Mailbox;

/**
 * MailboxFolder
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class Folder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var MailboxFolderCollection
     */
    private $folders;

    /**
     * @var MailboxMessageCollection
     */
    private $messages;

    /**
     * @var boolean
     */
    private $synchronized;

    /**
     * @param \Digitalshift\MailboxClientBundle\Entity\MailboxFolderCollection $folders
     */
    public function setFolders($folders)
    {
        $this->folders = $folders;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Entity\MailboxFolderCollection
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * @param \Digitalshift\MailboxClientBundle\Entity\MailboxMessageCollection $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Entity\MailboxMessageCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param boolean $synchronized
     */
    public function setSynchronized($synchronized)
    {
        $this->synchronized = $synchronized;
    }

    /**
     * @return boolean
     */
    public function getSynchronized()
    {
        return $this->synchronized;
    }


} 