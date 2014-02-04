cSphere
=======

Generic PHP Web-CMS with low footprint and high extensibility

The current version is available under the terms of the 'Simplified BSD License'

Website: http://www.csphere.eu

[![Build Status](https://travis-ci.org/csphere-cms/csphere.png?branch=dev)](https://travis-ci.org/csphere-cms/csphere)

[![Quality Score](https://scrutinizer-ci.com/g/csphere-cms/csphere/badges/quality-score.png?s=8d1d858ac3fffceb2cfb030c67d64c0380c4e44c)](https://scrutinizer-ci.com/g/csphere-cms/csphere/)


Table of contents
=================
1. Features
2. Requirements
3. Installation
4. Documentation


Features
========

This Web-CMS can be used for nearly every use case from a blog to a large community driven website with a forum and additional services. It is mainly optimized for fast creation and long-time maintenance of highly dynamic content. Thanks to advanced caching techniques it is able to scale up alot. It includes e.g.:

- Complete multi language support with English and German shipped already
- Modern and slim HTML5 interface using jQuery, Bootstrap and FontAwesome
- Plugins to easily add more functionality
- Themes to change the design and even override the design of all plugins
- Flawless underlying framework with high quality and zero external requirements
- Powerful debug and error functionality for developers
- Fast development of new plugins with rapid application development tools
- Full AJAX support for title, content and every sub-content (called box) 
- All you need to start: users, groups, a blog with tags and a contact form

We have over 10 years experience in providing OpenSource Web-CMS with PHP. This project started back in 2003 as a CMS for esport related pages and is now reduced to only contain the lowest possible feature set every website needs.

If you (mainly) need the following functionality you might NOT want to use cSphere:

- cSphere does NOT and won't ever provide any console tools to tamper with
- cSphere does NOT provide anything to assist with the creation of rich web APIs
- cSphere does NOT support any kind of PHP annotations or alike magic behavior
- cSphere does NOT use old autoloading techniques, it depends on namespaces instead


Requirements
============

At least PHP 5.4.0 or HHVM 2.4.0 on any webserver (PHP builtin webserver works, too)

The following PHP extensions must be available:

- date, fileinfo, filter, json, mcrypt, pcre, session, xml

One of the following database servers (with PDO extension in PHP):

- Microsoft SQL Server 2012+ / Microsoft LocalDB 2012+ (pdo_sqlsrv)
- MySQL 5.5+ / MariaDB 5.5+ (pdo_mysql)
- PostgreSQL 9.0+ (pdo_pgsql)
- SQLite 3.0+ (pdo_sqlite)

Legend: + means that the given version or any newer one will work


Installation
============

1. Download a release version or clone the GIT repository

2. Upload the whole csphere directory and index.php

3. Look into the webserver directory to grab the corresponding settings file

4. Change that file to match your environment and upload it to where index.php is located

5. Grant the csphere/config directory write access so that install can create a config file

6. Grant the csphere/storage directory and all subdirectories write access on filesystem

7. Do the following when running it on a self-managed webserver:

- Start your webserver, e.g. the PHP builtin webserver in tools/server directory

- Start your database server when not using SQLite, since SQLite is already builtin in PHP

Now open your website and follow the installation instructions


Documentation
=============

For further information look into the docs directory or visit our website

The API documentation can be generated inside the tools/documentor directory

Afterwards the API documentation is available in tools/tmp/api and includes all core classes

For support use our forums on the official website:

- http://www.csphere.eu

If you've found a bug or have a feature request use the Github Issue Tracker:

- https://github.com/csphere-dev/csphere/issues
