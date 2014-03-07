<?php

namespace Digitalshift\MailboxConnectionBundle\Entity;

/**
 * Folder
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
     * @var MimeMessageCollection
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

    public function __construct()
    {
        $this->folders = new FolderCollection();
        $this->messages = new MimeMessageCollection();
    }

    /**
     * @param \Digitalshift\MailboxConnectionBundle\Entity\FolderCollection $folders
     */
    public function setFolders($folders)
    {
        $this->folders = $folders;
    }

    /**
     * @return \Digitalshift\MailboxConnectionBundle\Entity\FolderCollection
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * @param Folder $subFolder
     */
    public function addSubFolder(Folder $subFolder)
    {
        $this->folders->add($subFolder);
    }

    /**
     * @param \Digitalshift\MailboxConnectionBundle\Entity\MimeMessageCollection $messages
     */
    public function setMessages(MimeMessageCollection $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return \Digitalshift\MailboxConnectionBundle\Entity\MimeMessageCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param MimeMessage $message
     */
    public function addMessage(MimeMessage $message)
    {
        $this->messages->add($message);
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