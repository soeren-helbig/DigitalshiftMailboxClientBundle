<?php

namespace Digitalshift\MailboxConnectionBundle\Tests\Mocks;

use Digitalshift\MailboxAbstractionBundle\Factory\FolderFactory;

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