### 1. Set Userdata

Open `app/config/parameters.yml` and add your userdata:

```yml
# parameters.yml
parameters:
    ...
    digitalshift_mailbox_client_user: XXX
    digitalshift_mailbox_client_password: XXX
    digitalshift_mailbox_client_url: XXX
    digitalshift_mailbox_client_port: XXX
```

### 2. Add Configuration

Open `app/config/config[_env].yml` and add your configuration:

```yaml
# app/config/config[_env].yml
digitalshift_mailbox_client:
    imap:
        user:     "%digitalshift_mailbox_client_user%"
        password: "%digitalshift_mailbox_client_password%"
        url:      "%digitalshift_mailbox_client_url%"
        port:     "%digitalshift_mailbox_client_port%"
        flags:    ['imap', 'ssl', 'novalidate-cert']
```

* available flags: see [imap_open()](http://www.php.net/manual/de/function.imap-open.php)
