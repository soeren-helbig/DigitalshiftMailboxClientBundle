<?php

namespace Digitalshift\MailboxClientBundle\Tests\Mocks;

use Digitalshift\MailboxClientBundle\Factory\FolderFactory;
use Digitalshift\MailboxClientBundle\Mailbox\Folder;

/**
 * FolderFactoryMock
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class FolderFactoryMock extends FolderFactory
{
    /**
     * @{inheritdoc}
     */
    public function byImapFolderListAndMessageList($folderPath, array $subFolders, array $messages)
    {
        $data = new \stdClass();
        $data->folderPath = $folderPath;
        $data->subfolders = $subFolders;
        $data->messages = $messages;

        return $data;
    }

} 