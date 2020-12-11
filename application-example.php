<?php

/*********************************************************
  THIS IS A TEMPLATE! Pick what you need for your app
**********************************************************/
return array(
	'application' => 'MyWebApp\\Application',
	'theme'       => 'WebApp\\BootstrapTheme\\BootstrapTheme',
	'name'        => 'My Bootstrap App',
	//'brandLogo'   => 'my-logo.png',
	'copyright'   => '&copy; '.date('Y').' by TechnicalGuru',
	'debug'       => true,
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
	'database'    => array(
		'host'        => 'my-db-host',
		'port'        => 3306,
		'user'        => 'my-db-user',
		'pass'        => 'my-db-password',
		'dbname'      => 'my-db-instance-name',
		'tablePrefix' => 'mywebapp_',
	),
	'dataModel'      => true,
	'authentication' => 'WebApp\\Auth\\UserDatabaseAuthenticator',
	'authorization'  => 'WebApp\\Auth\\UserRoleAuthorizator',
	'mailQueue'   => array(
		'timezone'    => 'Europe/Berlin',
		'mailMode'    => 'reroute',
		'smtpConfig'  => array(
			'host'         => 'my-smtp-server',
			'port'         => 587,
			'debugLevel'   => 0,
			'auth'         => true,
			'secureOption' => 'starttls',
			'charset'      => 'utf8',
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
);

