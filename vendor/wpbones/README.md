# WP Bones

![Version](https://img.shields.io/badge/version-0.5.11-green.svg?style=flat-square) ![WP Bones beta](https://img.shields.io/badge/status-beta-orange.svg?style=flat-square) ![License GPL](https://img.shields.io/badge/license-GPL-blue.svg?style=flat-square)


WP Bones is a framework for [WordPress](http://wordpress.org) written with [composer](https://getcomposer.org/).
You can use [WPX Followgram Light](https://github.com/gfazioli/WPXFollowgramLight) repo as a boilerplate to create a plugin.

As you know, WordPress doesn't support composer. So, I have used a little trick to fix this issue.

## Documentation

You'll find the [complete docs here](http://gfazioli.github.io/WPBones).

## Requirement

### Composer

    $ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

### Nodes

    $ sudo apt-get update && sudo apt-get install nodejs && sudo apt-get install npm
    $ sudo apt-get install nodejs-legacy


### Gulp

    $ sudo npm install --global gulp

## Boilerplate

You may start from [WPX Followgram Light](https://github.com/gfazioli/WPXFollowgramLight) repo as a boilerplate to create a WP Bones WordPress plugin.

## I love Laravel

First to all, this framework and the boilerplate plugin are inspired to [Laravel](http://laravel.com/) framework. Also, you will find a `bones` php shell executable like Laravel `artisan`.
After cloning the repo, you can:

Display help

    $ php bones

Change namespace

    $ php bones namespace MyPluginName

The last command is very important. You can change the namespace in anytime. However, I suggest you to make this only the first time, when the plugin is inactive.
After changing of the namespace, you can start to develop you plugin. Your namespace will be `MyPluginName`.