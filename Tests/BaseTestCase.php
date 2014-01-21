<?php

namespace Digitalshift\MailboxConnectionBundle\Tests;

/**
 * BaseTestCase
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $filePath
     * @return string
     */
    protected function getMailRawContent($filePath = null)
    {
        $file = fopen($filePath, 'r');
        $rawContent = fread($file, filesize($filePath));
        fclose($file);

        return $rawContent;
    }

} 