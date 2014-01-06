## DigitalshiftMailboxClientBundle

* encapsulates IMAP/POP3/… connections
* provides MailboxAbstractionLayer
* depends on [PECL/mailparse Library](http://pecl.php.net/package/mailparse)

### Supported Mailbox Connections / Protocols

* IMAP (ImapConnector)
* POP3 (Pop3Connector) - not yet implemented

### Abstraction-Layer

#### Mailbox / Folder

* access to mailbox folders, including their intire messages and subfolders (self-referencing)
* see [Mailbox/Folder.php](Mailbox/Folder.php) for complete fieldlist

#### Mailbox / Message

* access to mails, including raw content (mime-parts) & headers on the one hand and theirs abstract content (html-content, plain-content, attachements)
* see [Mailbox/Message.php](Mailbox/Message.php) for complete fieldlist
