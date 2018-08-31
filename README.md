# KongUserBundle

A tool to make it easier to implement the [Kong CE](https://docs.konghq.com) solution on a Symfony project

> This package is still under development and is far from being fully operationnal

## Dependencies

- PHP >= 7.1
- Symfony 3.4.*
- Guzzle Client ^7.2

## Installation


You'll be able to get the package with the following command `composer require adaniloff/kong-user-bundle`.

Then follow these steps: 

```php
<?php
/** In AppKernel */
$bundles = [
    // add the following line
    new \Adaniloff\KongUserBundle\AdaniloffKongUserBundle(),
];
```

Configure a guzzle client: 

```yaml
# in app/config/config.yml
eight_points_guzzle:
    clients:
        api_kong:
            # The admin base url, port included ; it will be defined later
            base_url: '%kong_user.host%'
            options:
                headers:
                    Accept: 'application/json'
                    Content-type: 'application/json'
```

Update your security config:

```yaml
# in app/config/security.yml
security:
    providers:
        # add this provider
        kong_user:
            id: Adaniloff\KongUserBundle\Security\KongUserProvider

    firewalls:
        main:
            guard:
                # add this authenticator 
                authenticators:
                    - Adaniloff\KongUserBundle\Security\KongAuthenticator
```

Then, make a good usage of `php bin/console config:dump-reference` to help you to finish the configuration !

## Example 

If you're already all good with your Kong installation, you should now be able to make the following requests :

```
curl -i -X GET --url http://localhost:8000/ --header 'Host: my.custom.server.com' -H 'Authorization: Basic QWxhZGRpbjpPcGVuU2VzYW1l'
```

This Basic Authentication request is from the [Kong documentation](https://docs.konghq.com/plugins/basic-authentication)
