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
     * name of folder in mailbox
     *
     * @var string
     */
    private $name;

    /**
     * path to folder in mailbox
     *
     * @var string
     */
    private $path;

    /**
     * contained sub-folders
     *
     * @var FolderCollection
     */
    private $folders;

    /**
     * contained messages
     *
     * @var MessageCollection
     */
    private $messages;

    /**
     * flag to show if folder is already synchronized with mailbox.
     * when receiving folders without the recursive flag, sub-folders
     * are created as empty ones (no messages & sub-folders will be
     * contained). this is done to prevent performance issues on large
     * mailboxes with deep directory-structure.
     *
     * @var boolean
     */
    private $synchronized;

    /**
     * @param \Digitalshift\MailboxClientBundle\Mailbox\FolderCollection $folders
     */
    public function setFolders($folders)
    {
        $this->folders = $folders;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Mailbox\FolderCollection
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * @param \Digitalshift\MailboxClientBundle\Mailbox\MessageCollection $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return \Digitalshift\MailboxClientBundle\Mailbox\MessageCollection
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