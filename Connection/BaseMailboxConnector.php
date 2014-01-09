<?php

namespace Digitalshift\MailboxClientBundle\Connection;

/**
 * BaseMailboxConnector
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
abstract class BaseMailboxConnector
{
    const TYPE_IMAP = 1;
    const TYPE_POP3 = 2;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var array
     */
    protected $flags;

    /**
     * @var mixed
     */
    protected $connection;

    /**
     * @param string $username
     * @param string $password
     * @param string $url
     * @param integer port
     * @param array $flags
     */
    protected function initialize($username, $password, $url, $port = 0, array $flags = array())
    {
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
        $this->port = $port;
        $this->flags = $flags;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    /**
     * @return string
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
} 