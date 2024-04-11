<?php
return [
	'class' => 'yii\db\Connection',
	'dsn' => 'mysql:host=' . $_ENV['TEST_PROD_MYSQL_HOST']
		. ';port=' . $_ENV['TEST_PROD_MYSQL_PORT']
		. ';dbname=' . $_ENV['TEST_PROD_MYSQL_DATABASE'],
	'username' => $_ENV['TEST_PROD_MYSQL_USER'],
	'password' => $_ENV['TEST_PROD_MYSQL_PASSWORD'],
	'charset' => 'utf8',

	// Schema cache options (for production environment)
	//'enableSchemaCache' => true,
	//'schemaCacheDuration' => 60,
	//'schemaCache' => 'cache',
];