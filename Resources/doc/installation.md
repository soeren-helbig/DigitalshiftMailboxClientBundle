### 1. Install via composer

#### 1.1 Update composer.json

Add MailboxConnectionBundle to your `composer.json`:

```json
"require": {
    ...,
    "digitalshift/mailbox-client-bundle": "dev-master",
    ...
},
```

#### 1.2 Update Vendors

Run `php composer.phar update` command.

### 2. Enable Bundle

Enable MailboxConnectionBundle in `app/AppKernel.php`:

```php
public function registerBundles()
{
    $bundles = array(
        ...,
        new Digitalshift\MailboxConnectionBundle\DigitalshiftMailboxConnectionBundle(),
        ...
    );

    ...
}
```

Thats it! Now you should configure the MailboxConnectionBundle, to set mailbox userdata for example. See [Configuration](configuration.md)-chapter.
