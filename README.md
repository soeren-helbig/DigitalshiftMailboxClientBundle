## DigitalshiftMailboxConnectionBundle

* encapsulates IMAP/POP3/… connections
* provides abstraction layer for MimeMessages / Mailbox-Folders
* depends on [PECL/mailparse Library](http://pecl.php.net/package/mailparse)

### Supported Mailbox Connections / Protocols

* IMAP (ImapConnector)
* POP3 (Pop3Connector) - not yet implemented

### Abstraction-Layer

#### Mailbox - Folder

* access to mailbox folders, including their intire messages and subfolders (self-referencing)
* see [Entity/Folder.php](Entity/Folder.php) for complete fieldlist

#### MimeMessage

* access to mails, including raw content (mime-parts) & headers
* see [Entity/MimeMessage.php](Entity/MimeMessage.php) for complete fieldlist

### Installation / Configuration

* install doc see: [installation](Resources/doc/installation.md)-chapter
* configuration doc see: [configuration](Resources/doc/configuration.md)-chapter

### Basic Usage

The main access point is the `digitalshift_mailbox_client.connector`-service. It encapsulates your mailbox-connection and internally uses factories to build [Folder](Entity/Folder.php)- and [MimeMessage](Entity/MimeMessage.php)-instances by the recieved mailbox data. In your controller (for example), you can do things like that:

```php
class DefaultController extends Controller
{
    ...

    public function indexAction()
    {
        /** @var ImapConnector $imapConnector */
        $imapConnector = $this->get('digitalshift_mailbox_client.connector');

        $folder = $imapConnector->getFolder();
        // OR
        $folder = $imapConnector->getFolder('INBOX');
        
        $message = $imapConnector->getMessage(1);
        // OR
        $message = $imapConnector->getMessage(1, 'INBOX');

        // Folder
        $folder->getName();
        $folder->getPath();
        $folder->getMessages();
        $folder->getFolders();

        // Message
        $message->getHeader();
        $message->getContent();
        $message->getSubject();
        $message->getHtmlContent();
        $message->getPlainContent();

        return $this->render(
            'DigitalshiftMailerBundle:Default:index.html.twig',
            array(
                'message' => $message,
                'folder' => $folder
            )
        );
    }
    
    ...

}
```
