<?php

/*********************************************************
  THIS IS A TEMPLATE! Pick what you need for your app
**********************************************************/
return array(
	// The Application class
	'application' => 'MyWebApp\\Application',
	// The theme
	'theme'       => 'WebApp\\BootstrapTheme\\BootstrapTheme',
	// The name as it appears in page headers
	'name'        => 'My Bootstrap App',
	// A logo (used in layouts)
	'brandLogo'   => 'my-logo.png',
	// A copyright for a footer
	'copyright'   => '&copy; '.date('Y').' by TechnicalGuru',
	// Be verbose about messages in UI (Do not enable in productive environments)
	'debug'       => false,
	// Switch on maintenance mode when you dont want front-end users to use yr app
	'maintenance' => false,

	// The router class for your app
	'router'      => array(
		'class'  => 'WebApp\\Router',
		'config' => array(
			'languages'   => array(
				'de' => 'Deutsch', 
				'en' => 'English',
			),
			'pageMap' => array(
				'/'           => 'MyWebApp\\Page\\',
				'/login.html' => 'WebApp\\BootstrapTheme\\LoginPage',
			),
		),
	),
	'pageLinks'   => array(
		'login'           => '/login.html',
		'logout'          => '/index.html',
		'forget_password' => '/forgot-password.html',
	),
	// Configuration of a vault (github.com/technicalguru/php-vault)
	'vault'       => array(
		// see php-vault doc for possible types
		'type'   => 'none', 
		// see php-vault doc for config
		'config'  => array(
			// Only for hashicorp vaults
			'uri'         => 'http://myvault',
			'roleId'      => 'roleId',
			'secretId'    => 'secretId',
			'renewTokens' => false,
			'maxTtl'      => 900,
			// Only for file vaults
			'filename'    => '/etc/ticketing.secrets',
			// Only for memory vault
			'secrets'     => '{"json-values"}',
		),
	),
	// see github.com/technicalguru/php-database
	'database'    => array(
		'host'        => 'my-db-host',
		'port'        => 3306,
		'dbname'      => 'my-db-instance-name',
		'tablePrefix' => 'mywebapp_',
		// Specify where in vault the username and secret is
		'security'    => array(
			'type'    => 'vault',
			'path'    => '/path/to/vault/secret',
		),
		// Or simply give auth data here
		'user'        => 'my-db-user',
		'pass'        => 'my-db-password',
	),
	// Use a data model
	'dataModel'      => true,
	// Use a service factory
	'serviceFactory' => array(
		'class' => 'MyWebApp\\Service\\ServiceFactory',
	),
	// Use your own User class (recommended)
	'authentication' => array(
		'class'    => 'WebApp\\Auth\\UserDatabaseAuthenticator',
		'config'   => array(
			'modelClass' => 'MyWebApp\\DataModel\\User',
		),
	),
	// Alternative default usage:
	// 'authentication' => 'WebApp\\Auth\\UserDatabaseAuthenticator',

	// Configure the authorizator class
	'authorization'  => array(
		'class' => 'WebApp\\Auth\\UserRoleAuthorizator',
		'config' => array(
			// Configure here
		),
	),
	// Alternative default usage:
	// 'authorization' => 'WebApp\\Auth\\UserRoleAuthorizator',

	// Mail config, see github.com/technicalguru/php-email
	'mailQueue'   => array(
		'timezone'    => 'Europe/Berlin',
		'mailMode'    => 'reroute',
		// Use username and password from vault
		'security'  => array(
			'type'    => 'vault',
			'path'    => '/path/to/vault/secret',
		),
		'smtpConfig'  => array(
			'host'         => 'my-smtp-server',
			'port'         => 587,
			'debugLevel'   => 0,
			'auth'         => true,
			'secureOption' => 'starttls',
			'charset'      => 'utf8',
			// Only when not using a vault
			'credentials'  => array(
				'user' => 'my-smtp-username',
				'pass' => 'my-smtp-password',
			),
		),
		'rerouteConfig' => array(
			'subjectPrefix' => '[Reroute]',
			'recipients'    => 'John Doe <john.doe@example.com>',
		),
		'bccConfig'   => array(
			'recipients'    => 'John Doe <john.doe@example.com>',
		),
		'debugAddress'  => 'John Doe <john.doe@example.com>',
		'defaultSender' => 'My WebApp <noreply@example.com>',
		'subjectPrefix' => '[My WebApp] ',
	),
	// Log Level, see github.com/technicalguru/php-utils
	'logLevel'    => "error",
	// Save error messages in database
	'logErrors'   => true,
	// Save simplified access log in database
	'accessLog'   => true,
);

