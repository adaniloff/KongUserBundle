# KongUserBundle

A tool to make it easier to implement the [Kong CE](https://docs.konghq.com) solution on a Symfony project

## Dependencies

- PHP >= 7.1
- Symfony 3.4.*
- Guzzle Client ^7.2

## Installation

> This repository is not on packagist yet.

You'll be able to get the package with the following command `composer require adaniloff/kong-user-bundle`.

Then follow these steps: 

```php
/** In AppKernel */
$bundles = [
            // add the following line
            new \Adaniloff\KongUserBundle\AdaniloffKongUserBundle(),
        ];
```

Configure a guzzle client: 

```
# in app/config/config.yml
eight_points_guzzle:
    clients:
        api_kong:
            # The admin base url, port included
            base_url: 'http://localhost:8001/'
            options:
                headers:
                    Accept: 'application/json'
                    Content-type: 'application/json'

```

Finally, update your security config:

```
# in app/config/security.yml
security:
    providers:
        # add this provider
        kong_user:
            id: Adaniloff\KongUserBundle\Security\KongUserProvider

    firewalls:
        main:
            # add this authenticator 
            guard:
                authenticators:
                    - Adaniloff\KongUserBundle\Security\KongAuthenticator


```

## Example 

If you're already all good with your Kong installation, you should now be able to make the following requests :

```
curl -i -X GET --url http://localhost:8000/ --header 'Host: my.custom.server.com' -H 'Authorization: Basic QWxhZGRpbjpPcGVuU2VzYW1l'
```

This Basic Authentication request is from the [Kong documentation](https://docs.konghq.com/plugins/basic-authentication)
