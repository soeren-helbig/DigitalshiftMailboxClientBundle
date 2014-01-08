### 1. Install via composer

#### 1.1 Update composer.json

Add MailboxClientBundle to your `composer.json`:

```json
"require": {
    …,
    "digitalshift/mailbox-client-bundle": "dev-master",
    …
},
```

#### 1.2 Update Vendors

Run `php composer.phar update` command.

### 2. Enable Bundle

Enable MailboxClientBundle in `app/AppKernel.php`:

```php
public function registerBundles()
{
    $bundles = array(
        …,
        new Digitalshift\MailboxClientBundle\DigitalshiftMailboxClientBundle(),
        …
    );

    …
}
```

