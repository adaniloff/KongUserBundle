# KongUserBundle

A tool to make it easier to implement the [Kong CE](https://docs.konghq.com) solution on a Symfony project

## Dependencies

- PHP >= 7.1
- Symfony ^3.4||^4.1
- Guzzle Client 7.2.*

## Installation

You'll be able to get the package with the following command `composer require adaniloff/kong-user-bundle`.

#### Symfony 4.1

Then follow these steps: 

```php
<?php
/** In config/bundles.php */
return [
    // add the following lines, in that order
    Adaniloff\KongUserBundle\AdaniloffKongUserBundle::class => ['all' => true],
    EightPoints\Bundle\GuzzleBundle\EightPointsGuzzleBundle::class => ['all' => true],
];
```

Configure a guzzle client: 

```yaml
# in config/eight_points_guzzle.yaml
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
# in config/security.yml
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

And add the bundle default configuration: 

```yaml
# in config/adaniloff_kong_user.yaml
adaniloff_kong_user:
    kong_host:
        url: "http://localhost:8000"
    auth:
        type: "key-auths"
```

#### Symfony 3.4

Then follow these steps: 

```php
<?php
/** In AppKernel */
$bundles = [
    // add the following lines, in that order
    new \Adaniloff\KongUserBundle\AdaniloffKongUserBundle(),
    new \EightPoints\Bundle\GuzzleBundle\EightPointsGuzzleBundle(),
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

And add the bundle default configuration: 

```yaml
# in app/config/config.yml
adaniloff_kong_user:
    kong_host:
        url: "http://localhost:8000"
    auth:
        type: "key-auths"
```

## Ready ?

You can make a good usage of `php bin/console config:dump-reference adaniloff_kong_user` to understand the configuration parameters !

## Example 

Let's say you have the following Kong configuration :

```
# A consumer with a username `Aladdin` :
### curl http://kong:8001/consumers
{"next":null,"data":[{"custom_id":null,"created_at":1538573756,"username":"Aladdin","id":"0de8a9b0-xxx-xxx-xxx-148bda37091f"}]}

# And some auth process like key-auth : ...
### curl http://kong:8001/key-auths
{"total":1,"data":[{"id":"63cb981b-xxxx-xxxx-xxxx-6f7b3aa89d15","created_at":1538573769066,"key":"ZRJuTVjbMqZK67A0T4BbJAgrqVNgOQaP","consumer_id":"0de8a9b0-xxx-xxx-xxx-148bda37091f"}]}

# ... or basic-auth, with a password `OpenSesame`
### curl http://kong:8001/basic-auths
{"total":1,"data":[{"created_at":1538635575626,"id":"83fbc811-1cc4-4fba-a006-39a195cf282f","username":"Aladdin","password":"02ae45bb86dac5bb1a2174fc3f2e8449c488a981","consumer_id":"0de8a9b0-0e89-450e-be1e-148bda37091f"}]}
```

Then you should be able to make the following requests :

```
# Key Auth request, with an auth key defined as "x-apikey"
curl -i -X GET --url http://localhost:8000/ --header 'Host: my.custom.server.com' -H 'x-apikey: ZRJuTVjbMqZK67A0T4BbJAgrqVNgOQaP'

# Basic Auth request
curl -i -X GET --url http://localhost:8000/ --header 'Host: my.custom.server.com' -H 'Authorization: Basic QWxhZGRpbjpPcGVuU2VzYW1l'
```

## See also ... 

* Learn more about the [basic auth plugin](https://docs.konghq.com/hub/kong-inc/basic-auth/)  
* Learn more about the [key auth plugin](https://docs.konghq.com/hub/kong-inc/key-auth/) 

