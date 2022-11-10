# technicalguru/webapp
This is a PHP framework for the easy-to-start development of a website. It addresses a few basic needs that every developer
faces when he wants to start a new website. This framework addresses:

* Authentication and Authorization
* Localization
* Flexible design, theme and layout of websites and individual pages
* Database Access (mostly MariaDB or MySQL)
* Data Model abstract layer to avoid any SQL writing
* Service layer support for business tasks
* REST service support by special page types
* Flexible URL routing (mapping the URL path to a specific Page class)
* Logging
* Email Sending
* Application Configuration
* Session Handling and Persistence

Most of them are not mandatory to use. The configuration allows to switch off many of them.

As I currently use this framework for my private projects only, there is not much documentation available yet. Feel free to ask
questions or checkout also the [php-webapp-template](https://github.com/technicalguru/php-webapp-template) repository which
provides starter templates.

The framework is mostly based on other PHP modules that are documented quite good. So you can consult them in order
to understand some of the features.

Remember: *technicalguru/webapp* is a framework to ease and speed up your development of a new website. It cannot solve all your problems but is a good starting point.

# License
This project is licensed under [GNU LGPL 3.0](LICENSE.md). 

# Installation

## By Composer

```sh
composer require technicalguru/webapp
```

## By Package Download
You can download the source code packages from [GitHub Release Page](https://github.com/technicalguru/php-webapp/releases)

# Start a WebApp
The best way is to use a template from [php-webapp-template](https://github.com/technicalguru/php-webapp-template) repository
but you can also start from scratch. You will need the configuration from [application-example.php](application-example.php)
and the main [index-example.php](index-example.php) file in the root of your web app. Notice that your web server needs to
route all requests to the `index.php` file. You could achieve this with this snippet:

```
    <IfModule mod_rewrite.c>
        Options -MultiViews

        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^ index.php [QSA,L]
    </IfModule>
```

in your `.htaccess` file

# Additional Remarks
Version 1.2 re-structured the rendering of form elements. The most visible change is that it requires you to create forms now with:

```
$form1 = new HorizontalForm($parant, 'my-form');
$form2 = new VerticalForm($parant, 'my-form');
$form3 = new InlineForm($parant, 'my-form');
$form4 = new GridForm($parant, 'my-form');
```

Furthermore, you shall verify the rendering of your forms because Javascript or layouts might be affected by the changes.

# Contribution
Report a bug, request an enhancement or pull request at the [GitHub Issue Tracker](https://github.com/technicalguru/php-webapp/issues).
