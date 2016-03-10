# Sendy API #

RESTful API for [Sendy](http://www.sendy.co) built with [Slim](http://www.github.com/codeguy/Slim)
Sendy-api works on Sendy DB, so **it has to be hosted on the same server as Sendy**.

## Installation ##

1. Launch `php composer.phar install` to install Slim framework
2. Copy `app/config-env-dist.php` to `app/config-env.php`
3. Fill in `app/config-env.php` credentials to Sendy MySQL DB

## API Authorization ##

Api authorizes with Sendy App Key (tabel: apps, colum: app_key) which has to pass with every request as `GET` parameter `app_key`
Example: `[your_api_uri]/subscribers/get/list?app_key=[your_app_key]&list=1`

## Methods ##

### Subscribers ###

**/subscribers/user/add**

description: Add user to subscribers list
method: `POST`
params: `email` - subscriber email, `list` - list id , `name` = subscriber name
return: `number of created subscribers`

**/subscribers/user/subscribe**

description: Subscribe user to list
method: `POST`
params: `email` - subscriber email, `list` - list id
return: `number of created subscribers`

**/subscribers/user/unsubscribe**

description: Unsubscribe user from list
method: `POST`
params: `email` - subscriber email, `list` - list id
return: `number of created subscribers`

**/subscribers/get/list**

description: Get subscribers list by list id
method: `GET`
params: `list` - list id
return: `list of subscribers`

**/subscribers/get/user**

description: Get subscribers by email
method: `GET`
params: `email` - subscriber email
return: `subscriber`

**/subscribers/truncate/list**

description: Truncate list of subscribers
method: `GET`
params: `list` - list id
return: `number of truncated subscribers`

**/subscribers/delete/user**

description: Delete user from subscribers (all subscriber lists)
method: `GET`
params: `email` - subscriber email
return: `number of truncated subscribers`

### Lists ###

**/lists/add**

description: Creates new list
method: `GET`
params: `name` - name
return: `list` (encrypted id for future send API use)

If list exists - query will be also successfull. Duplicate list will *not* be created.

**/lists/get**

description: Get lists by name wildcard
method: `GET`
params: `name` - wildcard name
return: `lists`

**/lists/show**

description: Show all lists by account API
method: `GET`
params: `app_key` - App API key
return: `lists`

### Campaigns ###

**/campaigns/get**

description: Get campaign info
method: `GET`
params: `id` - campaign id
return: `campaign`

**/campaigns/show**

description: Show all campaigns by account
method: `GET`
params: `app_key` - App API key
return: `campaigns`
