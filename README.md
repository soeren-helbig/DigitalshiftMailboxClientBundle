## DigitalshiftMailboxClientBundle

* encapsulates IMAP/POP3/… connections
* provides MailboxAbstractionLayer

### Supported Mailbox Connections / Protocols

* IMAP (ImapConnector)
* POP3 (Pop3Connector) - not yet implemented

### Abstraction-Layer

#### Mailbox / Folder

[Abstraction](Mailbox/Folder.php) for a mailbox folder, provides information like @name, @(imap-)path, @subfolders, @messages, ...

#### Mailbox / Message

[Abstraction](Mailbox/Message.php) for a mailbox folder.
